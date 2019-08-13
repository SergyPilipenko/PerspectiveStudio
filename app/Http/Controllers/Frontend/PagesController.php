<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use App\Models\Categories\Category;
use App\Models\Tecdoc\CarModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index(PartfixTecDoc $tecdoc)
    {
        $brands = $tecdoc->getBrands();

        $models = CarModel::whereIn('id', explode(',', '253,4731,3485'))
            ->with('modifications.attributes')
            ->get();
//        dd($models);

        return view('frontend.index', compact('brands'));
    }

    public function brand($brand)
    {
        dd($brand);
    }

    public function model($brand, $model)
    {
        $categories = Category::where('parent_id', null)->get();

        return view('frontend.categories.index', compact('categories', 'brand', 'model'));
    }
}
