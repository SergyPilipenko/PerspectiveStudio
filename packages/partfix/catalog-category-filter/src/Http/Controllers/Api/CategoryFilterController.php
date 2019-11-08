<?php

namespace Partfix\CatalogCategoryFilter\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use Illuminate\Http\Request;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;


class CategoryFilterController extends Controller
{
    private $categoryFilter;
    private $category;

    public function __construct(CategoryFilterInterface $categoryFilter, Category $category)
    {
        $this->categoryFilter = $categoryFilter;
        $this->category = $category;
    }

    public function filterqty(Request $request)
    {
        $this->validate($request, array(
            'categoryId' => 'required|numeric'
        ));

        $category = $this->category->findOrFail($request->categoryId);

        return $this->categoryFilter->getCategoryTotalProductsQty($category);
    }
}
