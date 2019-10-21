<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\MainFilter;
use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Catalog\Category as ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductCategoryController extends Controller
{
    /**
     * @var ProductsFilter
     */
    private $filters;
    /**
     * @var MainFilter
     */
    private $mainFilter;

    /**
     * ProductCategoryController constructor.
     * @param ProductsFilter $filters
     * @param MainFilter $mainFilter
     */
    public function __construct(ProductsFilter $filters, MainFilter $mainFilter)
    {
        $this->filters = $filters;
        $this->mainFilter = $mainFilter;
    }

    public function productCategory($slug, ProductCategory $productCategory)
    {
        $category = $productCategory->with('children', 'filterableAttributes')
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
//        $products = $category->getProducts(null, 20);
        $products = $category->products()
            ->with('productAttributeValues')
            ->filter($this->filters, $category->filterableAttributes)
            ->paginate(20);
        $filter = $this->mainFilter->renderFilterOptions($products, $category->filterableAttributes);
        dd($this->filters);

//        Cache::put("{$category->category_title}.'products'.page={1}", $products, 1);
//        dd($products->first()->manufacturer);
//        $pd = Product::filter($this->filters)->limit(20)->get();
//        dd($pd);
//        dd($category);
//
//        $attr = Product::whereHas('attributeValues', function($query) {
//            $query->join('attributes as a', 'product_attribute_values.attribute_id', 'a.id')
//                ->where('a.code', 'name')
//                ->where('product_attribute_values.text_value', 'Шлангопровод');
//        })->where('id', 4587776)->first();

        return view('frontend.product-categories.categories.show', compact('category', 'products'));
    }
}
