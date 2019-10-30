<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\ProductsFilter;
use App\Models\Catalog\Category as ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;
use Partfix\Paginator\App\Paginator;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProductCategoryController extends Controller
{
    /**
     * @var ProductsFilter
     */
    private $filters;
    /**
     * @var CategoryFilter
     */
    private $mainFilter;
    /**
     * @var CategoryFilter
     */
    private $categoryFilter;

    /**
     * ProductCategoryController constructor.
     * @param ProductsFilter $filters
     * @param CategoryFilter $categoryFilter
     */
    public function __construct(ProductsFilter $filters, CategoryFilter $categoryFilter)
    {
        $this->filters = $filters;

        $this->categoryFilter = $categoryFilter;
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
        $products = $category->products()
            ->with('productAttributeValues')
            ->filter($this->filters, $category->filterableAttributes)
            ->paginate(20);

        return view('frontend.product-categories.categories.show', compact('category', 'products'));
    }
}
