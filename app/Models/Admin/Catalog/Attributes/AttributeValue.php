<?php

namespace App\Models\Admin\Catalog\Attributes;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'product_attribute_values';

    public function productAttribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
