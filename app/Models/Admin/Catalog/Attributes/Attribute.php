<?php

namespace App\Models\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $inputs = [
        'type' => [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'price' => 'Price',
            'boolean' => 'Boolean',
            'select' => 'Select',
            'multiselect' => 'Multiselect',
            'datetime' => 'Datetime',
            'date' => 'Date',
            'image' => 'Image',
            'file' => 'File',
        ],
        'validation' => [
            'numeric' => 'Число',
            'email' => 'Email',
            'decimal' => 'Число с точкой',
            'url' => 'URL',
        ]
    ];

    public function scopeCustom($query)
    {
        return $query->where('is_user_defined', true);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values');
    }
}
