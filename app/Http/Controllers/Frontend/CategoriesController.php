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
        $categories = Category::where('parent_id', null)->get();

        return view('frontend.categories.index', compact('categories', 'modification'));
    }

    public function show($modification, $categories, PartfixTecDoc $tecDoc)
    {
        $route_categories = explode('/', $categories);
        $categories = Category::whereIn('slug', $route_categories)->get();

        if(count($route_categories) != $categories->count() || !$categories->count()) {
            abort(404);
        }

        $category_slug = array_pop($route_categories);
        $category = $categories->last();

        $parts = [];

        foreach ($category->td_categories as $item) {
            $tecDoc->section_parts = [];
            $tecDoc->getNestedSections($modification, $item->passanger_car_tree->passanger_car_trees_id);
            $parts = array_merge($parts, $tecDoc->section_parts);
        }
        dd($parts);

        return view('frontend.categories.show', compact('modification','category'));
    }
}
