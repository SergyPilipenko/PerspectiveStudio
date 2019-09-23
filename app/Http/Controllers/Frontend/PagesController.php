<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Garage;
use App\Classes\PartfixTecDoc;
use App\Classes\RoutesParser\CarRoutesParser;
use App\Classes\RoutesParser\RoutesParserInterface;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\AutoType;
use App\Models\Cart\CartInterface;
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
use App\Models\Catalog\Category as ProductCategory;

class PagesController extends Controller
{

    /**
     * PagesController constructor.
     */
    public function __construct()
    {
        $this->middleware('frontend');
    }

    public function index(PartfixTecDoc $tecdoc, Garage $garage, ProductCategory $category)
    {

        $brands = $tecdoc->getCheckedBrands(AutoType::where('code', 'cars')->first()->id);

        $garage = \Session::get('garage')
            ? PassangerCar::whereIn('id', collect(\Session::get('garage'))->pluck('modification_id'))->with('attributes')->get()
            : null;

        $current_auto = \Session::get('current-auto') ? : null;

        $categories = $category->active()->orderBy('parent_id', 'asc')->get();

        $routes = [
            'get-brands-by-models-created-year' => route('api.get-brands-by-models-created-year')
        ];

        return view('frontend.index', compact('brands', 'garage', 'current_auto', 'routes', 'categories'));
    }

    public function brand(Request $request)
    {

        dd(Route::getCurrentRoute()->uri);
//        dd($brand);
    }

    public function model($brand, $model, RoutesParserInterface $rotesParser)
    {
        $categories = Category::where('parent_id', null)->get();

        $manufacturer = ManufacturersUri::where('slug', $brand)->with('passangercar.models')->firstOrFail();

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
            'auto.model' => route('frontend.model', [$brand, $model]),
        ];

        return view('frontend.categories.index', compact('categories', 'brand', 'model', 'models', 'routes'));
    }

    public function modification($brand, $model, $modification, Garage $garage, RoutesParserInterface $rotesParser)
    {
        if(!$modification) $modification = $model;
        $garage->setActiveCar($modification);
        $garage = \Session::get('garage')
            ? PassangerCar::whereIn('id', collect(\Session::get('garage'))->pluck('modification_id'))->with('attributes')->get()
            : null;
        $current_auto = \Session::get('current-auto');
        $categories = Category::where('parent_id', null)->get();

        return view('frontend.car.index', compact('garage', 'current_auto', 'categories', 'modification', 'brand', 'model'));
    }

    public function category($brand, $model, $modification, $category, Garage $garageInstance, RoutesParserInterface $routesParser, PartfixTecDoc $tecDoc)
    {
        $garage_list = $garageInstance->getGarageList();

        $garage = $garage_list->count()
            ? PassangerCar::whereIn('id', $garage_list->pluck('modification_id'))->with('attributes')->get()
            : null;

        $category = Category::whereSlug($category)->with('children')->firstOrFail();

        $current_auto = $garageInstance->getActiveCar();

        $categories = $category->children;
//        $products = Product::whereIn('id', collect($category->getParts($modification))->pluck('product_id'))->get();
//
//        dd($products);
        $parts = Product::whereIn('id', collect($category->getParts($modification))->pluck('product_id'))->get();
//        dd($parts);
        return view('frontend.car.index',
            compact('category', 'garage', 'current_auto', 'categories',
                'brand', 'model', 'modification', 'route_name', 'route_parameters', 'parts')
        );
    }


    public function product()
    {

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
        try {
            $garage->removeCar($id);
        } catch (\Exception $exception) {
            dd($exception);
            exit();
        }
        return redirect()->route('frontend.index');
    }

    public function setCarYear(Request $request, Garage $garage)
    {
        $garage->setCurrentYear($request->selected_year);
    }

    public function getRouteNameAndParameters($brand, $model, $modification, $slug)
    {
        try {
            $route['name'] = route($brand.'.'.$model.'.'.'frontend.categories.show', [$modification, $slug]);
            $route['name'] = $brand.'.'.$model.'.'.'frontend.categories.show';
            $route['parameters'] = [$modification];
        } catch (\InvalidArgumentException $exception) {
            $route['name'] = $brand.'.'.'frontend.categories.show';
            $route['parameters'] = [$model, $modification];
        }

        return $route;
    }
}
