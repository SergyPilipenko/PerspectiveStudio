<?php

namespace App\Models\Content\Rubric;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Model;

class RubricGroup extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'rubric_group_mappings', 'rubric_group_id', 'category_id')
            ->orderBy('position', 'ASC');
    }
}
