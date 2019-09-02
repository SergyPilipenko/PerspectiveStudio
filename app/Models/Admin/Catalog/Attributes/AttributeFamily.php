<?php

namespace App\Models\Admin\Catalog\Attributes;

use Illuminate\Database\Eloquent\Model;

class AttributeFamily extends Model
{
    public function attribute_groups()
    {
        return $this->hasMany(AttributeGroup::class);
    }
}
