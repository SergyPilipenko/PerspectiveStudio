<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Catalog\Product\Product;
use App\Models\Catalog\Category as ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductCategoryController extends Controller
{

    public function productCategory($slug, ProductCategory $productCategory)
    {
        $category = $productCategory->with('children', 'products.attribute_family.attribute_groups.group_attributes', 'filterableAttributes')
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
        $products = $category->getProducts(null, 20);
        $pd = Product::filter()->limit(20)->get();
        dd($pd);
//        dd($category);

//        $attr = Product::whereHas('attributeValues', function($query) {
////            $query->where('attributes.code', 'article');
//            $query->join('attributes as a', 'product_attribute_values.attribute_id', 'a.id')
//                ->where('a.code', 'name')
//                ->where('product_attribute_values.text_value', 'Шлангопровод');
//        })->where('id', 4587776)->first();


        return view('frontend.product-categories.categories.show', compact('category', 'products'));
    }
}
