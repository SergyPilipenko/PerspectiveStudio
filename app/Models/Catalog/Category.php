<?php

namespace App\Models\Catalog;

use App\Helpers\Locale;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Categories\CategoryDistinctPassangerCarTree;
use App\Search\Indexers\CategoriesIndexer;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Kalnoy\Nestedset\NodeTrait;
use App\Http\Requests\RequestInterface;
use Illuminate\Support\Facades\App;

class Category extends Model implements CategoryInterface
{
    use NodeTrait;
    use HasTranslations;

    protected $table = 'catalog_categories';
    public $categoryTypes = ['default', 'tecdoc'];
    public $translatable = ['category_title', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];
    public $locale;

    protected $image_path = 'img/upload/product-categories/';
    /**
     * @var ProductInterface
     */
    private $product;


    public function __construct(array $attributes = [])
    {
        if(!$this->locale) {
            $this->locale = new Locale();
        }
        $this->product = resolve(ProductInterface::class);

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

    public function newCollection(array $models = Array())
    {
        return new \Kalnoy\Nestedset\Collection($models);
    }

    /**
     * @param RequestInterface $request
     */
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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function getTecdocProducts($modifications, $limit)
    {
        $tecdoc = resolve('PartfixTecDoc');
        $parts = $tecdoc->getPartfixTecdocSectionPartsIds($this, $modifications);

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
}
