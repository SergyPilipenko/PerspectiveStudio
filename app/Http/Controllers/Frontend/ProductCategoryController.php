<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Catalog\Category as ProductCategory;
use App\Http\Controllers\Controller;
use App\Repositories\CatalogCategory\CategoryRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;
use Partfix\Paginator\App\Paginator;
use Partfix\Paginator\App\PaginatorInterface;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;

class ProductCategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ProductCategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function productCategory($slug, ProductCategory $productCategory)
    {
        $category = $productCategory->with('children', 'filterableAttributes')
            ->where('slug->' . app()->getLocale(), $slug)->with(['children.children', 'parent.parent'])->firstOrFail();

        switch ($category->parent_id) {
            case null:return $this->index($category);
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
        $products = $this->categoryRepository->getCategoryProducts($category);
        $categoryLink = request()->getPathInfo();

        return view('frontend.product-categories.categories.show', compact('category', 'products', 'categoryLink'));
    }
}
