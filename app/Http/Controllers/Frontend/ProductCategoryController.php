<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Catalog\Category as ProductCategory;
use App\Http\Controllers\Controller;
use App\Repositories\CatalogCategory\CategoryRepository;
use Partfix\MetaTags\Model\MetaTags;

class ProductCategoryController extends Controller
{
    private $categoryRepository;
    private $metaTags;

    /**
     * ProductCategoryController constructor.
     * @param  CategoryRepository  $categoryRepository
     * @param  MetaTags  $metaTags
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        MetaTags $metaTags
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->metaTags = $metaTags;
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
        $meta_tags = $this->getCategoryMetaTags($category);

        return view('frontend.product-categories.categories.index', compact('category', 'meta_tags'));
    }

    public function show($category)
    {
        $products = $this->categoryRepository->getCategoryProducts($category);
        $categoryLink = request()->getPathInfo();
        $meta_tags = $this->getCategoryMetaTags($category);


        return view('frontend.product-categories.categories.show', compact('category', 'products', 'categoryLink', 'meta_tags'));
    }

    private function getCategoryMetaTags($category)
    {
        return [
            'category_title' => $category->category_title,
            'page' => isset(request()->page) && request()->page > 1 ? request()->page : '',
            'filterable_options' => $this->metaTags->getTitleFilterableOptions($category) ?? ''
        ];
    }
}
