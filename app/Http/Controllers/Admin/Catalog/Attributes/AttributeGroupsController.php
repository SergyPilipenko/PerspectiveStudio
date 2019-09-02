<?php

namespace App\Http\Controllers\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Attributes\AttributeGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeGroupsController extends Controller
{
    public function store(Request $request, AttributeGroup $attributeGroup)
    {
        $this->validate($request, array(
            'name' => 'required|unique:attribute_groups,name',
            'position' => 'required|numeric|min:1'
        ));



        return $request;
    }
}
