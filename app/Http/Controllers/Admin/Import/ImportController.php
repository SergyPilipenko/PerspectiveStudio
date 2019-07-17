<?php

namespace App\Http\Controllers\Admin\Import;

use App\Article;
use App\Helpers\Routes;
use App\Imports\PriceFilter;
use App\Models\Admin\Import\ImportByUrl;
use App\Models\Admin\Import\ImportSetting;
use App\Models\Tecdoc\ArticleNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ImportController extends Controller
{

    protected $options = [
        'name' => 'Название',
        'brand' => 'Производитель',
        'article' => 'Код',
        'description' => 'Описание',
        'used' => 'Б/У',
        'price' => 'Цена',
        'quantity' => 'Кол-во',
        'original' => 'Ориг. производители',
        'picture' => 'Фото'
    ];
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
        return view('admin.import.create', [
            'routes' => json_encode($routes->getRoutesByName('admin.import'))
        ]);
    }

    public function edit($id, Routes $routes)

    {
        $import_setting = ImportSetting::findOrFail($id);
//        dd(json_decode($import_setting->scheme));

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

//        foreach ($rows as $row) {
//            $articles[] = $row[0];
//        }

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

//        $file = Session::get('file_path');
//
//        $reader = IOFactory::load($file);
//
//        $rows = $reader->getActiveSheet()->toArray();
//
//        $articles = implode($rows);
//
//        return $filterSubset->getPreview($rows, 10)->toJson();

    }

    public function import_price(Request $request, $import_price_id)
    {
        $rows = $request->type::import($request);

        $import_setting = ImportSetting::find($import_price_id);


        $prices = [];
        $articles = [];
        foreach ($rows as $row) {
            $articles[] = array_shift($row);
        }

//        dd($article = ArticleNumber::whereIn('datasupplierarticlenumber', $articles)->get());

//        dd($rows);
//        dd($rows);
//        dd($request->file('file'));
//        dd($this->parse($request, (new PriceFilter)));
    }

    public function destroy($id)
    {
        ImportSetting::findOrFail($id)->delete();

        Session::flash('flash', 'Схема загрузки была удалена');

        return back();
    }
}
