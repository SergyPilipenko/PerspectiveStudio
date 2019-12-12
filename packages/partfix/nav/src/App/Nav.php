<?php


namespace Partfix\Nav\App;

use App\Models\Catalog\CategoryInterface;
use App\Models\Content\Rubric\Rubric;

class Nav implements NavInterface
{
    public $category;
    private $rubric;

    public function __construct(
        CategoryInterface $category,
        Rubric $rubric
    )
    {
        $this->category = $category;
        $this->rubric = $rubric;
    }

    public function getNav()
    {
        return $this->rubric->where('show_in_menu', true)->orderBy('position', 'ASC')->get();
//        $categories = $this->category->rootCategories()->orderBy('position', 'asc')->get();
//
//        return $categories;
    }
}
