<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use App\Models\Categories\Category;
use App\Models\Tecdoc\DistinctPassangerCarTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartsController extends Controller
{
    public function index($modificationId, PartfixTecDoc $tecDoc)
    {
//        $sections = $tecDoc->getNestedSections($modificationId);

        $categories = Category::all();

        return view('frontend.parts.index', compact('categories'));
    }

    public function show($id, PartfixTecDoc $tecDoc)
    {
        $category = Category::find($id)->td_categories()->get()->pluck('distinct_pct_id');
//        dd($category);
//        119512
//        dd($tecDoc->getNestedSections(119512));

        $part = $tecDoc->getNestedSections(119512, $category->first()->id);


        return view('frontend.categories.index', compact('category'));
    }
}
