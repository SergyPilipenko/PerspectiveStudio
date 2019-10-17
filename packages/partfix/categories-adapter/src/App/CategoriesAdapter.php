<?php

namespace Partfix\CategoriesAdapter\App;
use App\Models\Catalog\CategoryInterface;
use App\Models\Categories\Category;


class CategoriesAdapter implements CategoriesAdapterInterface
{
    /**
     * @var CategoryInterface
     */
    private $category;
    /**
     * @var App\Models\Categories\Category
     */
    private $tecdocCategory;


    /**
     * CategoriesAdapter constructor.
     * @param CategoryInterface $category
     * @param Category $tecdocCategory
     */
    public function __construct(
        CategoryInterface $category,
        Category $tecdocCategory
    )
    {
        $this->category = $category;
        $this->tecdocCategory = $tecdocCategory;
    }

    public function getRootCategories()
    {
        $categories = $this->category->where('parent_id', null)->get();
        $tecdocCategories = $this->tecdocCategory->where('parent_id', null)->get();

        return $tecdocCategories->concat($categories);
    }
}
