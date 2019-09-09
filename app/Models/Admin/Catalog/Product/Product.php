<?php

namespace App\Models\Admin\Catalog\Product;

use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Catalog\Product\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['type', 'attribute_family_id', 'article', 'parent_id'];

    /**
     * @var ProductAttributeValue instance
     */
    private $productAttributeValue;

    /**
     * @var ProductImage instance
     */
    public $productImage;


    protected static function boot()
    {
        parent::boot();
        static::deleted(function($product) {
            if($product->images->count()) {
                File::deleteDirectory($product->productImage->path . $product->id);
            }
        });
    }

    public function __construct()
    {
        parent::__construct();

        $this->productAttributeValue = new ProductAttributeValue;
        $this->productImage = app()->make(ProductImage::class);
    }


    public function attribute_family()
    {
        return $this->belongsTo(AttributeFamily::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function attribute_value()
    {
        $this->belongsTo(Attribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
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

            $product->update($request);

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

            DB::connection()->getPdo()->commit();

            return $product;

        } catch (\PDOException $e) {
            dd($e);
            DB::connection()->getPdo()->rollBack();
        }
    }
}
