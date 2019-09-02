<?php

namespace App\Http\Controllers\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\AttributeGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeFamiliesController extends Controller
{
    public function index()
    {
        return view('admin.catalog.attribute-families.index');
    }

    public function create(AttributeGroup $attributeGroup)
    {
        $groups = $attributeGroup->default()->with('attributes')->get();
        $custom_attributes = Attribute::custom()->get();

        return view('admin.catalog.attribute-families.create', compact('groups','custom_attributes'));
    }
}
