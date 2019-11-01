<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Catalog\Category as ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;
use Partfix\Paginator\App\Paginator;
use Partfix\Paginator\App\PaginatorInterface;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;

class ProductCategoryController extends Controller
{
    /**
     * @var ProductsFilter
     */
    private $filters;
    /**
     * @var CategoryFilter
     */
    private $categoryFilter;
    /**
     * @var SQLQueryBuilder
     */
    private $builder;
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductCategoryController constructor.
     * @param ProductsFilter $filters
     * @param CategoryFilter $categoryFilter
     * @param SQLQueryBuilder $builder
     * @param PaginatorInterface $paginator
     * @param Product $product
     */
    public function __construct(
        ProductsFilter $filters,
        CategoryFilter $categoryFilter,
        SQLQueryBuilder $builder,
        PaginatorInterface $paginator,
        Product $product
    )
    {
        $this->filters = $filters;
        $this->categoryFilter = $categoryFilter;
        $this->builder = $builder;
        $this->paginator = $paginator;
        $this->product = $product;
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
        $res = $category->newProducts();
        $query = $this->product->newFilter($res, $category->filterableAttributes);
        $result = $query->getArrayResult();
        $products = $this->paginator->paginate($result, 20);
        $ids = $products->getCollection()->pluck('id');
        $productsWithData = Product::whereIn('id', $ids)->with('productAttributeValues')->get();
        $products->setCollection($productsWithData);
//        dd($products);
        return view('frontend.product-categories.categories.show', compact('category', 'products'));
    }
}
