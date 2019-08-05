<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    public function tecdoc_categories()
    {
        return $this->belongsToMany(CategoryDistinctPassangerCarTree::class, 'category_distinct_passanger_car_trees', 'category_id', 'distinct_pct_id');
    }

    public function td_categories()
    {
        return $this->hasMany(CategoryDistinctPassangerCarTree::class);
    }
}
