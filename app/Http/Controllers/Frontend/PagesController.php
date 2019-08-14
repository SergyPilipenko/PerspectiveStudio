<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use App\Models\Categories\Category;
use App\Models\ManufacturersUri;
use App\Models\ModelsUri;
use App\Models\Tecdoc\CarModel;
use App\Models\Tecdoc\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Transliterate;

class PagesController extends Controller
{
    public function index(PartfixTecDoc $tecdoc)
    {
        $brands = $tecdoc->getBrands();
        $models = CarModel::whereIn('id', explode(',', '253,4731,3485'))
            ->with('modifications.attributes')
            ->get();
        \Session::put('selected-year', 1323);
        return view('frontend.index', compact('brands'));
    }

    public function brand($brand)
    {
        dd($brand);
    }

    public function model($brand, $model)
    {
        $categories = Category::where('parent_id', null)->get();

        $manufacturer = ManufacturersUri::where('slug', $brand)->with('passangercar.models')->first();

        $models = ModelsUri::where([
            'slug' => $model,
            'manufacturer_id' => $manufacturer->manufacturer_id
        ])->with('model')->get();

        return view('frontend.categories.index', compact('categories', 'brand', 'model', 'models'));
    }
}
