<?php

namespace App\Http\Controllers\Admin\Import;

//use App\Article;
use App\Helpers\Routes;
use App\Imports\PriceFilter;
use App\Models\Admin\Import\ImportByUrl;
use App\Models\Admin\Import\ImportColumn;
use App\Models\Admin\Import\ImportSetting;
use App\Models\Admin\Import\InvalidPrice;
use App\Models\Admin\Import\SuppliersMapping;
use App\Models\Prices\Price;
use App\Models\Prices\UploadHistory;
use App\Models\Tecdoc\ArticleNumber;
use App\Models\Tecdoc\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;


class ImportController extends Controller
{


    /**
     * ImportController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Routes $routes)
    {
        $import_settings = ImportSetting::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.import.index', [
            'routes' => json_encode($routes->getRoutesByName('admin.import')),
            'import_settings' => $import_settings
        ]);
    }

    public function create(Routes $routes)
    {
        $columns = ImportColumn::all();

        return view('admin.import.create', [
            'routes' => json_encode($routes->getRoutesByName('admin.import')),
            'columns' => $columns
        ]);
    }

    public function edit($id, Routes $routes)

    {
        $import_setting = ImportSetting::findOrFail($id);

        return view('admin.import.edit', [
            'import_setting' => $import_setting,
            'options' => $this->options,
            'routes' => json_encode($routes->getRoutesByName('admin.import'))
        ]);
    }

    /**
     *
     * @param Request $request
     * @param PriceFilter $filterSubset
     * @return false|string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function parse(Request $request, PriceFilter $filterSubset)
    {

        $rows = $request->type::import($request);
        $articles = [];

        $filtered = $filterSubset->getPreview($rows, 10);

        if(request()->wantsJson()) return $filtered->toJson();

        return $filtered;

    }

    public function store(Request $request, PriceFilter $filterSubset)
    {
        $this->validate($request, [
            'title' => 'required',
            'columns' => 'required',
            'type' => 'required'
        ]);

        $import_type = $request->type::create($request);

        $importSettings = new ImportSetting();
        $importSettings->title = $request->title;
        $importSettings->scheme = $request->columns;
        $importSettings->importable_id = $import_type->id;
        $importSettings->importable_type = get_class($import_type);
        $importSettings->save();
        Session::flash('flash', 'Новая схема была сохранена успешно');
        return json_encode($importSettings->save());

    }

    public function import_price(Request $request, $import_setting_id)
    {
        //Грузим строки из файла
        $rows = $request->type::import($request);
        //Парсим схему и колонки
        $import_setting = ImportSetting::parse($import_setting_id);

        $prepare = Price::prepareRowsToSave($rows, $import_setting);

        try {
            DB::connection()->getPdo()->beginTransaction();
            Price::savePrices($prepare, $import_setting);
            DB::connection()->getPdo()->commit();
        } catch (\PDOException $e) {

            dd($e);
            DB::connection()->getPdo()->rollBack();
        }
        return redirect()->back();
    }


}
