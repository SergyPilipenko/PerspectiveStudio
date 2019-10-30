<?php

namespace App\Models\Catalog;

use App\Entities\ArticleNumber;
use App\Helpers\Locale;
use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\CategoryFilterableAttribute;
use App\Models\Admin\Catalog\Attributes\FilterableAttribute;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Admin\Catalog\ProductCategory;
use App\Models\Categories\CategoryDistinctPassangerCarTree;
use App\Search\Indexers\CategoriesIndexer;
use App\Traits\HasTranslations;
use Doctrine\ORM\EntityManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kalnoy\Nestedset\NodeTrait;
use App\Http\Requests\RequestInterface;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;
use Illuminate\Support\Facades\Cache;

class Category extends Model implements CategoryInterface
{
    use NodeTrait;
    use HasTranslations;

    protected $table = 'catalog_categories';
    public $categoryTypes = ['default', 'tecdoc'];
    public $translatable = ['category_title', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];
    public $locale;

    protected $image_path = 'img/upload/product-categories/';
    private $product;
    private $filter;
    private $em;

    public function __construct(array $attributes = [])
    {
        if(!$this->locale) {
            $this->locale = new Locale();
        }
        $this->product = resolve(ProductInterface::class);
        $this->filter = resolve(CategoryFilterInterface::class);
        $this->em = resolve(EntityManager::class);
        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();
        if(env('APP_DEBUG')) {
            static::created(function ($category) {
                $categoriesIndexer = app(CategoriesIndexer::class);
                $categoriesIndexer->index($category);
            });

            static::updated(function ($category) {
                $categoriesIndexer = app(CategoriesIndexer::class);
                $categoriesIndexer->reindex($category);
            });
        }
    }

    public function tecdoc_categories()
    {
        return $this->belongsToMany(CategoryDistinctPassangerCarTree::class, 'category_distinct_passanger_car_trees', 'category_id', 'distinct_pct_id');
    }



    public function filterableAttributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_filterable_attributes', 'catalog_category_id', 'attribute_id');
    }

    public function newCollection(array $models = Array())
    {
        return new \Kalnoy\Nestedset\Collection($models);
    }

    public function updateCategory(RequestInterface $request)
    {

        $this->setCategoryTranslations($request);

        $this->activity = $request->category_activity ? 1 : 0;
        $this->position = $request->position;

        $this->updateImage($request);

        $tree = null;

        if($request->tree234) {
            $tree = explode(',', $request->tree234);
            foreach ($tree as &$item) {
                $item = (int) $item;
            }
        }

        $this->tecdoc_categories()->sync($tree);
        $this->filterableAttributes()->sync($request->filterableAttributes);
        $this->update();
    }

    protected function updateImage(RequestInterface $request)
    {
        if($this->image && $request->has_image == "false") {
            if(File::exists($this->image)) {
                File::delete($this->image);
                $this->image = null;
            }
            return;
        }

        $file = $request->file('category_image');

        if(!$file) return;

        if($this->image && File::exists($this->image)){
            File::delete($this->image);
        }


        $file_name = time() . $file->getClientOriginalName();
        $file->move($this->image_path, $file_name);
        $this->image = $this->image_path.$file_name;
    }


    public function getRouteKeyName()
    {
        return ['id' => 'category', 'slug' => 'slug'];
    }

    public function products($modifications = null)
    {
        switch ($this->type) {
            case 'tecdoc':
//                $result = Cache::get('category.'.$this->_lft.'.'.$this->_rgt);
//
//                if(!$result) {
//                DB::connection()->enableQueryLog();

                $result = DB::connection($this->connection)->select("
                    SELECT p.id
                    FROM distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent
                    JOIN partfix.product_article_tree art on parent.passanger_car_trees_id = art.nodeid
                    JOIN products as p on art.article_number_id = p.id
                    where node._lft between parent._lft and parent._rgt and parent.id in (SELECT dc.id FROM partfix.catalog_categories cc
                    JOIN category_distinct_passanger_car_trees as ct ON cc.id = ct.category_id
                    JOIN distinct_passanger_car_trees as dc on ct.distinct_pct_id = dc.id
                    where cc._lft >= {$this->_lft} and cc._rgt <= {$this->_rgt})
                    ");
                $result = array_column(json_decode(json_encode($result), true), 'id');

//                $a = 3;
//                $products = Product::whereIn('id', $result)->get();
//                $a = 3;
//                return Product::whereIn('id', $result)->get();
                $qb = $this->em->createQueryBuilder();
                $qb->select('p')
                    ->from(\App\Entities\Product::class, 'p')
                    ->add('where', $qb->expr()->in('p.id', $result));
//                $qb->innerJoin(ArticleNumber::class, 'a');
                $a = 3;
                $products = $qb->getQuery()
                    ->getArrayResult();
                $a = 3;
//                dd(count($products));
                return Product::whereIn('id', $result);
                break;
            default:
                return $this->belongsToMany(Product::class, 'product_categories');
        }

    }

    public function productsFiltered()
    {
        return $this->belongsToMany(ProductInterface::class, 'product_categories');
    }

    public function getTdp($modifications)
    {
        dd($this->builder());
    }

    public function getTecdocProducts($modifications, $limit)
    {
        $tecdoc = resolve('PartfixTecDoc');
        $parts = $modifications ? $tecdoc->getModificationSectionPartsIds($this, $modifications) : $tecdoc->getAllSectionPartsIds($this);

        return $this->product->getProducts($parts, $limit);
    }

    public function getProducts(array $modifications = null, $limit = false)
    {
        switch ($this->type) {
            case 'tecdoc':
                return $this->getTecdocProducts($modifications, $limit);
                break;
            default:
                return $this->product->getProducts($this->products()->get()->pluck('id')->toArray(), $limit);
        }
    }

    public function scopeActive($query)
    {
        return $query->where('activity', true);
    }

    public function scopeRootCategories($query)
    {
        return $query->where('parent_id', null);
    }

    public function getFilter()
    {
        return $this->filter->renderCategoryFilter($this);
    }
}
