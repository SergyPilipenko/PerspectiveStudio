<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\ProductsFilter;
use App\Models\Catalog\Category as ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;
use Partfix\Paginator\App\Paginator;

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
//        $products = $category->products()->paginate(20);
//        dd($products->count());3
//        $total = Cache::get('category.'.$category->id.'.total');
//
//        if(!isset($total)) {
//            $sql = "SELECT count(*) as count FROM distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent
//                        JOIN tecdoc2018_db.article_tree art on parent.passanger_car_trees_id = art.nodeid
//                        JOIN products as p on art.article_number_id = p.id
//                        where node._lft between parent._lft and parent._rgt and parent.id in (SELECT dc.id FROM partfix.catalog_categories cc
//                        JOIN category_distinct_passanger_car_trees as ct ON cc.id = ct.category_id
//                        JOIN distinct_passanger_car_trees as dc on ct.distinct_pct_id = dc.id
//                        where cc._lft >= {$category->_lft} and cc._rgt <= {$category->_rgt})";
//
//            $result = DB::connection('mysql')->selectOne($sql);
//            Cache::put('category.'.$category->id.'.total', $result->count, now()->addMinutes(5));
//            $total = $result->count;
//        }
//        ;
//        $sql = "SELECT art.article_number_id as product_id FROM distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent
//                        JOIN tecdoc2018_db.article_tree art on parent.passanger_car_trees_id = art.nodeid
//                        JOIN products as p on art.article_number_id = p.id
//                        where node._lft between parent._lft and parent._rgt and parent.id in (SELECT dc.id FROM partfix.catalog_categories cc
//                        JOIN category_distinct_passanger_car_trees as ct ON cc.id = ct.category_id
//                        JOIN distinct_passanger_car_trees as dc on ct.distinct_pct_id = dc.id
//                        where cc._lft >= {$category->_lft} and cc._rgt <= {$category->_rgt}) limit 20";
//        $sql .= request()->page > 1 ? " offset ".request()->page: " offset 0";
//
//        $products = array_column(json_decode(json_encode(DB::connection('mysql')->select($sql), true)), 'product_id');
//
//        $paginator = new Paginator();
//        $products = $paginator->paginate($products, 20);



//        dd($total);

//        dd(Cache::get('category.'.$category->id.'.total'));
//
//        $
//        $paginator = new Paginator();
//        dd($paginator->paginate($products, 10));
        $products = $category->products()
            ->with('productAttributeValues')
            ->filter($this->filters, $category->filterableAttributes)
            ->paginate(20);

//        $products = DB::connection('mysql')->select($sql);
//        dd(count($products));
//        dd($products);
//        dd($this->filters);

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
