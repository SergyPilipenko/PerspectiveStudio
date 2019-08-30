<?php

namespace App\Http\Controllers\Admin\Catalog\Attributes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeGroupsController extends Controller
{
    public function index()
    {
        return view('admin.catalog.attribute-groups.index');
    }
}
