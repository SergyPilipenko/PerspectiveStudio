<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use App\Models\Categories\Category;
use App\Models\ManufacturersUri;
use App\Models\ModelsUri;
use App\Models\Tecdoc\CarModel;
use App\Models\Tecdoc\Manufacturer;
use App\Models\Tecdoc\PassangerCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Transliterate;

class PagesController extends Controller
{
    public function index(PartfixTecDoc $tecdoc)
    {
        $brands = $tecdoc->filterBrandsByModelsYear();
        dd($brands);
        $models = CarModel::whereIn('id', explode(',', '253,4731,3485'))
            ->with('modifications.attributes')
            ->get();
        $garage = \Session::get('garage')
            ? PassangerCar::whereIn('id', collect(\Session::get('garage'))->pluck('modification_id'))->with('attributes')->get()
            : null;
        $current_auto = \Session::get('current-auto') ? : null;

        return view('frontend.index', compact('brands', 'garage', 'current_auto'));
    }

    public function brand($brand)
    {
        dd($brand);
    }

    public function model($brand, $model)
    {
        $categories = Category::where('parent_id', null)->get();

        $manufacturer = ManufacturersUri::where('slug', $brand)->with('passangercar.models')->first();

        $models = PassangerCar::whereIn('modelid', [19,36,59])->with('attributes')->filter([
            [
                'attributetype' => 'BodyType',
                'displayvalue' => 'Седан'
            ],
            [
                'attributetype' => 'EngineType',
                'displayvalue' => 'Бензиновый двигатель',
            ],
            [
                'attributetype' => 'Capacity',
                'displayvalue' => '2 l',
            ],
        ])->get();

        $models = ModelsUri::where([
            'slug' => $model,
            'manufacturer_id' => $manufacturer->manufacturer_id
        ])->with('model')->get();

        $routes = [
            'set-car-year' => route('set-car-year'),
            'get-models-body-types' => route('api.tecdoc.get-models-body-types'),
            'get-models-engines' => route('api.tecdoc.get-models-engines'),
            'get-filtered-modifications' => route('api.tecdoc.get-filtered-modifications'),
            'auto.model' => route('auto.model', [$brand, $model]),
        ];

        return view('frontend.categories.index', compact('categories', 'brand', 'model', 'models', 'routes'));
    }

    public function modification($brand, $model, $modification)
    {
        \Session::put('current-auto', [
            'modification_id' => $modification,
            'modification_year' => \Session::get('car-year')
        ]);
        \Session::push('garage', [
            'modification_id' => $modification,
            'modification_year' => \Session::get('car-year')
        ]);
        return redirect('/');
    }

    public function changeCurrentCar($id)
    {
        $garage = collect(\Session::get('garage'));
        $current_modification = $garage->where('modification_id', $id)->first();
        \Session::put('current-auto', [
            'modification_id' => $current_modification['modification_id'],
            'modification_year' => $current_modification['modification_year']
        ]);
        return back();
    }

    public function removeCar($id)
    {
        $garage = collect(\Session::get('garage'));
        $current_auto = \Session::get('current-auto');

        foreach ($garage as $key => $item) {
            if($item['modification_id'] == $id) {
                \Session::forget('garage.'.$key);

                if($current_auto['modification_id'] == $id) {
                    $new_current_auto = collect(\Session::get('garage'))->first();
                    \Session::put('current-auto', [
                        'modification_id' => $new_current_auto['modification_id'],
                        'modification_year' => $new_current_auto['modification_year']
                    ]);
                }

                return back();
            } continue;
        }
        return back();
    }
}
