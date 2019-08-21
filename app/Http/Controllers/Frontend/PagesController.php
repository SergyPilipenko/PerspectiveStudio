<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Garage;
use App\Classes\PartfixTecDoc;
use App\Classes\RoutesParser\CarRoutesParser;
use App\Classes\RoutesParser\RoutesParserInterface;
use App\Models\Categories\Category;
use App\Models\ManufacturersUri;
use App\Models\ModelsUri;
use App\Models\Tecdoc\CarModel;
use App\Models\Tecdoc\Manufacturer;
use App\Models\Tecdoc\ModelConstrucitonInterval;
use App\Models\Tecdoc\PassangerCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Transliterate;

class PagesController extends Controller
{
    public function index(PartfixTecDoc $tecdoc, Garage $garage)
    {
//        $garage->clear();
        $brands = $tecdoc->getBrands();

//        $bm = ModelConstrucitonInterval::whereRaw('REPLACE(`stopped`, ``, CURRENT_DATE)', 2019)->get();
//        dd($tecdoc->getBrandsByModelsCreatedYear(1960));

        $garage = \Session::get('garage')
            ? PassangerCar::whereIn('id', collect(\Session::get('garage'))->pluck('modification_id'))->with('attributes')->get()
            : null;

        $current_auto = \Session::get('current-auto') ? : null;

        $routes = [
            'get-brands-by-models-created-year' => route('api.get-brands-by-models-created-year')
        ];

        return view('frontend.index', compact('brands', 'garage', 'current_auto', 'routes'));
    }

    public function brand(Request $request)
    {

        dd(Route::getCurrentRoute()->uri);
//        dd($brand);
    }

    public function model($model = null, RoutesParserInterface $rotesParser)
    {
        $brand = $rotesParser->getBrand();

        $model ?? $model = $rotesParser->getModel();

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
            'auto.model' => route('auto.' . $brand . '.model', [$model]),
        ];

        return view('frontend.categories.index', compact('categories', 'brand', 'model', 'models', 'routes'));
    }

    /**
     * В СЛУЧАЕ СРАБАТЫВАНИЯ РОУТА
     * Route::get($brand . "-$item-{modification}", 'Frontend\PagesController@modification')->name('auto.model.modification');
     * $modification это $model ¯\_(ツ)_/¯
     */
    public function modification($model, $modification = null, Garage $garage, RoutesParserInterface $rotesParser)
    {


        if(!$modification) $modification = $model;


        $garage->setActiveCar($modification);

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

    public function removeCar($id, Garage $garage)
    {
//        dd(\Session::forget('garage'));
        try {
            $garage->removeCar($id);
        } catch (\Exception $exception) {
            dd($exception);
            exit();
        }

        return back();
    }

    public function setCarYear(Request $request, Garage $garage)
    {
        $garage->setCurrentYear($request->selected_year);
    }
}
