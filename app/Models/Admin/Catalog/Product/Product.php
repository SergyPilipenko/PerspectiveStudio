<?php

namespace App\Models\Admin\Catalog\Product;

use App\Classes\PriceFilter\PriceFilterInterface;
use App\Events\ProductUpdatedEvent;
use App\Filters\NewProductsFilter;
use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Attributes\AttributeValue;
use App\Models\Admin\Catalog\Product\ProductImage;
use App\Models\Catalog\Category;
use App\Models\Prices\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;
use Partfix\QueryBuilder\Model\MysqlQueryBuilder;

class Product extends Model implements ProductInterface
{
    protected $fillable = ['type', 'attribute_family_id', 'quantity', 'article', 'parent_id', 'depends_quantity'];
    protected $table = 'products';
    public $priceFilter;
    private $newProductsFilter;
    private $productsFilter;
    private $simpleQueryBuilder;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($product) {
            app()->make('App\Search\Indexers\ProductsIndexer')->index($product);
        });

        static::deleted(function($product) {
            app()->make('App\Search\Indexers\ProductsIndexer')->remove($product);
            if($product->images->count()) {
                File::deleteDirectory($product->productImage->savePath . $product->id);
            }
        });
    }

    public function __construct()
    {
        $this->productAttributeValue = new ProductAttributeValue;
        $this->productImage = app()->make(ProductImage::class);
        $this->priceFilter = app(PriceFilterInterface::class);
        $this->newProductsFilter = app(NewProductsFilter::class);
        $this->productsFilter = app(ProductsFilter::class);
        $this->simpleQueryBuilder = app(SQLQueryBuilder::class);
        parent::__construct();
    }

    public function getAttribute($key)
    {
        if (! method_exists(self::class, $key) && ! in_array($key, $this->fillable) && ! isset($this->attributes[$key]) && $key != 'pivot') {
            if (isset($this->id)) {
                if($key == 'price') return $this->getPrice();
                $attribute = $this->productAttributeValues->where('code', $key)->first();

                if($attribute) {
                    $field = ProductAttributeValue::$attributeTypeFields[$attribute->type];

                    return $attribute->$field;
                }

                return $this->getAttributeValue($key);
            }
        }

        return parent::getAttribute($key);
    }

    public function getRouteKeyName()
    {
        return ['id' => 'product', 'slug' => 'slug'];
    }

    public function scopeFilter($query, ProductsFilter $filters, $filterableItems = [])
    {


        return $filters->apply($query, $filterableItems);
    }

    private $productAttributeValue;

    public $productImage;

    public function attribute_family()
    {
        return $this->belongsTo(AttributeFamily::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'product_id', 'id');
    }

    public function productAttributeValues()
    {
        return $this->attributeValues()
//            ->select('a.code')
            ->join('attributes as a', 'product_attribute_values.attribute_id', 'a.id');
    }

    public function getDefaultPrice()
    {
        return $this->getAttrValue('price');
    }

    public function getPrice()
    {
        return $this->priceFilter->getProductPrice($this);
    }

    public function productCanBeDisplayed()
    {
        if($this->getPrice() > 0) {
            return true;
        }

        return false;
    }

    public function tecdocPrices()
    {
        return $this->hasMany(Price::class, 'article_id', 'id');
    }

    public function getProducts(array $ids, $paginate = false)
    {
        $products = $this->with('images')->whereIn('id', $ids)->paginate($paginate);

        if(!$products->count()) return $products;

        $products = resolve('App\Models\Admin\Catalog\Attributes\Attribute')->setProductsAttributes($products);

        return $products;
    }

    public function getProductById($id)
    {
        $product = $this->with('attribute_family.attribute_groups.group_attributes', 'images')->findOrFail($id);
        $product->custom_attributes = $product->getProductAttributes();
        $product->price = $product->getPrice();

        return $product;
    }

    public function getProduct($slug)
    {
        $id = $this->getProductByIdSlug($slug);
        if(!$id) {
            abort(404);
        }

        return $this->getProductById($id);
    }


    public function getProductAttributes()
    {
        $sql = "
        SELECT pav.*, a.* FROM `products` p
        JOIN product_attribute_values pav ON p.id = pav.product_id
        JOIN attributes a ON pav.attribute_id = a.id
        WHERE p.id = {$this->id}";
        $attributes = DB::connection('mysql')->select($sql);

        $formatted = [];
        foreach ($attributes as $attribute) {
            if(!in_array($attribute->code, ProductAttributeValue::$ignoreAttributes)) {
                $value = ProductAttributeValue::$attributeTypeFields[$attribute->type];
                $formatted[$attribute->code] = $attribute->$value;
            }
        }

        return $formatted;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getProductByIdSlug($slug)
    {
        $product =  DB::connection('mysql')->selectOne("
           SELECT p.id FROM attributes a
            LEFT JOIN product_attribute_values pv on a.id = pv.attribute_id
            LEFT JOIN products p ON pv.product_id = p.id
            WHERE a.code = 'slug' AND pv.text_value = '".$slug."'
        ");
        if(!$product) abort(404);

        return $product->id;
    }

    public function getAttrValues(array $attributes_codes)
    {
        $attributes = [];
        foreach ($attributes_codes as $attributes_code) {
            $attributes[] = $this->getAttributeValue($attributes_code);
        }

        return $attributes;
    }


    public function getAttrValue(string $code, $attribute_id = null)
    {
        if(in_array($code, ['article'])) return $this->$code;
        if(isset($this->attribute_family) && isset($this->attribute_family->attribute_groups))
        {
            foreach ($this->attribute_family->attribute_groups as $group)
            {
                $get_attribute = $group->group_attributes->where('code', $code)->first();
                if($get_attribute) {
                    $field_code = ProductAttributeValue::$attributeTypeFields[$get_attribute['type']];
                    $attribute = ProductAttributeValue::where('product_id', $this->id)->where('attribute_id', $get_attribute->id)->first();
                    if($attribute) return $attribute->$field_code;
                }
            }
        }
    }

    public function super_attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_super_attributes');
    }

    public function productUpdate(array $request, int $id)
    {
        $product = $this->findOrFail($id);

        try {

            DB::connection()->getPdo()->beginTransaction();

            if(isset($request['depends_quantity'])) {
                $request['depends_quantity'] = true;
            } else {
                $request['depends_quantity'] = false;
            }

            $product->update($request);
            $this->updateProductsFlatTable($request, $product);
            $attributes = $product->attribute_family->custom_attributes()->get();

            foreach ($attributes as $attribute) {

                if (!isset($request[$attribute->code]) || (in_array($attribute->type, ['date', 'datetime']) && !$request[$attribute->code]))
                    continue;

                $attributeValue = $this->productAttributeValue->where([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id
                ])->first();

                if (!$attributeValue) {
                    $this->productAttributeValue->createProductValue([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $request[$attribute->code]
                    ]);

                } else {
                    $this->productAttributeValue->where('id', $attributeValue->id)->update([
                        ProductAttributeValue::$attributeTypeFields[$attribute->type] => $request[$attribute->code]
                    ]);
                }
            }
            if(isset($request['categories'])) {
                $product->categories()->sync(explode(',', $request['categories']));
            } else {
                $product->categories()->delete();
            }


            event(new ProductUpdatedEvent($product));

            DB::connection()->getPdo()->commit();

            return $product;

        } catch (\PDOException $e) {
            dd($e);
            DB::connection()->getPdo()->rollBack();
        }
    }

    public function newFilter(MysqlQueryBuilder $builder, $filterableItems)
    {
        return $this->productsFilter->apply($builder, $filterableItems);
    }

    public function belongsModification(int $modification) : ?bool
    {
        $query = $this->simpleQueryBuilder->select(env('DB_TECDOC_DATABASE') . '.article_numbers AS an', ['*'])
            ->multiJoin(env('DB_TECDOC_DATABASE') . '.article_links AS al', [
                'an.supplierid' => 'al.supplierid',
                'an.datasupplierarticlenumber' => 'al.datasupplierarticlenumber'
            ])->multiJoin(env('DB_TECDOC_DATABASE') . '.passanger_car_pds AS pds', [
                'al.productid' => 'pds.productid',
                'an.supplierid' => 'pds.supplierid'
            ])->where('an.id', $this->id)->where('pds.passangercarid', $modification)->limit(1)->getResult();

        return count($query) ? true : false;
    }

    protected function updateProductsFlatTable($request, $product)
    {
        $filterableAttributes = $attributes = Attribute::where('is_filterable', true)->get();
        $data = [];
        foreach ($filterableAttributes as $filterableAttribute) {
            $code = $filterableAttribute->code;
            if(array_key_exists($code, $request)) $data[$code] = $request[$code];
        }

        if(count($data)) DB::table('products_flat')->where('id', $product->id)->update($data);
    }
}
