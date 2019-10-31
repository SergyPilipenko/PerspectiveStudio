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

//        $products = $category->products()
//            ->with('productAttributeValues')
//            ->filter($this->filters, $category->filterableAttributes)
//            ->paginate(20);



        $res = $category->newProducts();

        $product = $this->product->newFilter($res, $category->filterableAttributes);
        dd($product->getQuery());
        $res = $product->getArrayResult();
        $products = $this->paginator->paginate($res, 20);

//        dd(1);
//
//        $query = $this->builder
//            ->select("distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent", ["p.id"])
//            ->join("tecdoc2018_db.article_tree as art", "parent.passanger_car_trees_id", "art.nodeid")
//            ->join("products as p", "art.article_number_id", "p.id")
//            ->whereBetween("node._lft", "parent._lft", "parent._rgt")
//            ->whereIn("parent.id", function ($test) {
//                return $test->select("partfix.catalog_categories as cc", ["dc.id"])
//                    ->join("category_distinct_passanger_car_trees as ct", "cc.id", "ct.category_id")
//                    ->join("distinct_passanger_car_trees as dc", "ct.distinct_pct_id", "dc.id")
//                    ->where("cc._lft", 51, '>=')
//                    ->where("cc._rgt", 54, '<=');
//            });

        return view('frontend.product-categories.categories.show', compact('category', 'products'));
    }
}
