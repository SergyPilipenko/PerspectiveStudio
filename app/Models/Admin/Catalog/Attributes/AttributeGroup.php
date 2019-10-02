<?php

namespace App\Models\Admin\Catalog\Attributes;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    public function scopeDefault($query)
    {
        $query->where('is_user_defined', false);
    }

    public function group_attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_group_mappings');
    }
}
