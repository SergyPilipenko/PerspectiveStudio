<?php

namespace App\Models\Categories;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    public function getRouteKeyName()
    {
        return ['id' => 'category', 'slug' => 'slug'];
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function($category) {
            if($category->seo) {
                $category->seo->delete();
            }
        });
    }



    public function tecdoc_categories()
    {
        return $this->belongsToMany(CategoryDistinctPassangerCarTree::class, 'category_distinct_passanger_car_trees', 'category_id', 'distinct_pct_id');
    }

    public function scopeGetParts($query, $modification) : array
    {
        $nodes = [];
        $parts = [];

        foreach ($this->td_categories()->with('passanger_car_tree')->get() as $item) {
            $nodes[] = $item->passanger_car_tree->passanger_car_trees_id;
        }

        if(count($nodes)) {
            foreach ($nodes as $node) {
                $parts = array_merge($parts, app('PartfixTecDoc')->getNestedSectionParts($modification, $node));
            }
        }

        return $parts;
    }

    public function td_categories()
    {
        return $this->hasMany(CategoryDistinctPassangerCarTree::class);
    }

    public function seo()
    {
       return $this->morphOne(Seo::class, 'entity','entity_model');
    }
}
