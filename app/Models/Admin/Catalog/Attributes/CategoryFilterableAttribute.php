<?php

namespace App\Models\Admin\Catalog\Attributes;

use Illuminate\Database\Eloquent\Model;

class CategoryFilterableAttribute extends Model
{
    protected $table = 'category_filterable_attributes';
    public $timestamps = false;
}
