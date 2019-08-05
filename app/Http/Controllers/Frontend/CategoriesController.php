<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use App\Models\Categories\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index($modification)
    {
        $categories = Category::all();

        return view('frontend.categories.index', compact('categories', 'modification'));
    }

    public function show($modification, $category, PartfixTecDoc $tecDoc)
    {
        $category = Category::find($category);
        $parts = [];

        foreach ($category->td_categories as $item) {
            $tecDoc->getNestedSections($modification, $item->passanger_car_tree->passanger_car_trees_id);
            $parts[] = $tecDoc->section_parts;

        }

        return view('frontend.categories.show', compact('modification','category'));
    }
}
