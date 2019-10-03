<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog\Category as ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{

    public function productCategory($slug, ProductCategory $productCategory)
    {
        $category = $productCategory->with('children', 'products.attribute_family.attribute_groups.group_attributes')
            ->where('slug->' . app()->getLocale(), $slug)->firstOrFail();

        return view('frontend.product-categories.categories.show', compact('category'));
    }
}
