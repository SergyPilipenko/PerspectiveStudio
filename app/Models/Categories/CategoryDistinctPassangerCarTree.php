<?php

namespace App\Models\Categories;

use App\Models\Tecdoc\DistinctPassangerCarTree;
use Illuminate\Database\Eloquent\Model;

class CategoryDistinctPassangerCarTree extends Model
{
//    protected $fillable = ['category_id', 'distinct_pct_id'];

    public function passanger_car_tree()
    {
        return $this->belongsTo(DistinctPassangerCarTree::class, 'distinct_pct_id', 'id');
    }

    public function scopeGetCategorySelects($query, $category_id)
    {
        $checked = $query->get();
        $checked->selected = $checked->filter(function ($category, $key) use ($category_id) {
            return $category->category_id == $category_id;
        });
        $checked->disabled = $checked->filter(function ($category, $key) use ($category_id) {
            return $category->category_id != $category_id;
        });

        return $checked;
    }

}
