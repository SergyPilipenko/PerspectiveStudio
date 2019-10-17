<?php


namespace Partfix\Nav\App;

use App\Models\Catalog\CategoryInterface;

class Nav implements NavInterface
{
    public $category;

    public function __construct(
        CategoryInterface $category
    )
    {
        $this->category = $category;
    }

    public function getNav()
    {
        $categories = $this->category->rootCategories()->orderBy('position', 'asc')->get();

        return $categories;
    }
}
