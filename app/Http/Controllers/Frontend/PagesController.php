<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Car\Car;
use App\Classes\Car\CarInterface;
use App\Classes\Garage;
use App\Classes\PartfixTecDoc;
use App\Classes\RoutesParser\CarRoutesParser;
use App\Classes\RoutesParser\RoutesParserInterface;
use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\AutoType;
use App\Models\Cart\CartInterface;
use App\Models\Catalog\CategoryInterface;
use App\Models\Categories\Category;
use App\Models\ManufacturersUri;
use App\Models\ModelsUri;
use App\Models\Tecdoc\PassangerCar;
use App\Repositories\CatalogCategory\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;
use Transliterate;
use App\Models\Catalog\Category as ProductCategory;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    /**
     * @var ProductsFilter
     */
    private $filters;
    /**
     * @var CategoryFilter
     */
    private $categoryFilter;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ProductCategoryController constructor.
     * @param ProductsFilter $filters
     * @param CategoryFilter $categoryFilter
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        ProductsFilter $filters,
        CategoryFilter $categoryFilter,
        CategoryRepository $categoryRepository
    )
    {
        $this->middleware('frontend');
        $this->filters = $filters;
        $this->categoryFilter = $categoryFilter;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(PartfixTecDoc $tecdoc, Garage $garage, ProductCategory $category)
    {
        $brands = $tecdoc->getCheckedBrands(AutoType::where('code', 'cars')->first()->id);

        $routes = [
            'get-brands-by-models-created-year' => route('api.get-brands-by-models-created-year')
        ];

        return view('frontend.index', compact('brands', 'routes'));
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

    public function modification($brand, $model, $modification, Garage $garage, CarInterface $car)
    {
        $garage->setActiveCar($modification);

        $car = $car->getCar($modification);

//        $categories = Category::where('slug', 'legkovye')->with('children.children')->first();
        $category = resolve(CategoryInterface::class)
            ->where('slug->' . app()->getLocale(), 'legkovye')
            ->with('children.children')
            ->firstOrFail();

        if($category->children->count()) {
            $children = $category->children;
        }

        return view('frontend.car.index', compact('category','children', 'car', 'brand', 'model', 'modification'));
    }

    public function category($brand, $model, $modification, $category, CarInterface $car, Product $product)
    {
        $category = resolve(CategoryInterface::class)
            ->where('slug->' . app()->getLocale(), $category)
            ->with('children.children')
            ->firstOrFail();

        $products = $this->categoryRepository->getCategoryProducts($category, $modification);

        $car = $car->getCar($modification);

        $categoryLink = request()->getPathInfo();

        return view('frontend.car.category', compact('car', 'category', 'products', 'brand', 'model', 'modification', 'categoryLink'));
    }


    public function clearGarage(Garage $garage)
    {
        $garage->clear();

        return redirect()->route('frontend.index');
    }

    public function changeCurrentCar($id)
    {
        $garage = collect(Session::get('garage'));

        $current_modification = $garage->where('modification_id', $id)->first();
        Session::put('current-auto', [
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
