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
            ->where('slug->' . app()->getLocale(), $slug)->with('children.children')->firstOrFail();

        switch ($category->parent_id) {
            case null:
                return $this->index($category);
                break;
            default:
                return $this->show($category);
        }
    }

    public function index($category)
    {
        return view('frontend.product-categories.categories.index', compact('category'));
    }

    public function show($category)
    {
        $products = $category->getProducts(null, 1);

        return view('frontend.product-categories.categories.show', compact('category', 'products'));
    }
}
