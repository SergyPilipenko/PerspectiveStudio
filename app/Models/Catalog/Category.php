<?php

namespace App\Models\Catalog;

use App\Helpers\Locale;
use App\Models\Admin\Catalog\Product\Product;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Kalnoy\Nestedset\NodeTrait;
use App\Http\Requests\RequestInterface;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use NodeTrait;
    use HasTranslations;

    protected $table = 'catalog_categories';
    public $translatable = ['category_title', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];
    public $locale;
    protected $image_path = 'img/upload/product-categories/';

    public function __construct()
    {
        parent::__construct();

        if(!$this->locale) {
            $this->locale = new Locale();
        }

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

        $this->activity = $request->category_activity ? true : false;
        $this->position = $request->position;

        $this->updateImage($request);

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

    public function scopeActive($query)
    {
        return $query->where('activity', true);
    }
}
