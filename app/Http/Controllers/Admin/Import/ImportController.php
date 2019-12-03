<?php

namespace App\Http\Controllers\Admin\Import;

use App\Helpers\Routes;
use App\Imports\PriceFilter;
use App\Models\Admin\Import\ImportColumn;
use App\Models\Admin\Import\ImportSetting;
use App\Models\Prices\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
//    protected $options = [
//        'name' => 'Название',
//        'brand' => 'Производитель',
//        'article' => 'Код',
//        'description' => 'Описание',
//        'used' => 'Б/У',
//        'price' => 'Цена',
//        'quantity' => 'Кол-во',
//        'original' => 'Ориг. производители',
//        'picture' => 'Фото'
//    ];

    private $builder;
    private $price;
    /**
     * ImportController constructor.
     * @param SQLQueryBuilder $builder
     */
    public function __construct(SQLQueryBuilder $builder, Price $price)
    {
        $this->middleware('auth:admin');
        $this->builder = $builder;
        $this->price = $price;
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
//        dd($import_setting);
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

        $this->getArticlesInTecdoc($prepare,$import_setting_id);
        dd('end');
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

    //НЕ БЫЛО ВРЕМЕНИ НАПИСАТЬ НОРМАЛЬНО >:(

    public function getArticlesInTecdoc($prices, $import_setting_id)
    {
        $fields = $this->queryFields($prices);

        $sql = "SELECT an.`id` as `article_id`, an.`datasupplierarticlenumber` as `article`,  s.description as `supplier`  FROM " . env('DB_TECDOC_DATABASE') .".`article_numbers` an
                JOIN  " . env('DB_TECDOC_DATABASE') .".suppliers s on an.`supplierid` = s.id
                WHERE (an.`datasupplierarticlenumber`, s.description) in  (";
        foreach ($fields as $key => $field) {
            if($key > 0) {
                $sql .= ', ';
            }
            $sql .= "('" . $field['article'] . "', '" . $field['supplier'] . "')";
        }
        $sql .= ')';

        $result = DB::connection('mysql')->select($sql);
        $result = json_decode(json_encode($result), true);
        $diff = $this->diff($fields, $result);
        $valid = [];
        $data = $this->updateData($prices, $result, $import_setting_id);
        $this->price->createOrUpdatePrice($data);
    }

    private function queryFields($prices)
    {
        $data = [];

        foreach ($prices as $key => $price) {
            $item = [];
            $item['article'] = $price['article'];
            $item['supplier'] = $price['supplier'];
            $data[] = $item;
        }

        return $data;
    }

    private function diff($array1, $array2)
    {
        $diff = [];
        foreach ($array1 as $item) {
            if(!in_array($item, $array2)) $diff[] = $item;
        }

        return $diff;
    }

    private function articleId($result, $price)
    {
        dd(3);
        foreach ($result as $item) {
            dd(2);
        }
    }

    private function updateData($prices, $result, $import_setting_id)
    {
        $data = [];
        $invalid = [];
        foreach ($prices as $price) {
            foreach ($result as $item) {
                if($price['article'] == $item['article'] && $price['supplier'] == $item['supplier']) {
                    $dataItem = [];
                    $dataItem['price'] = (float) $price['price'];
                    $dataItem['article_id'] = $item['article_id'];
                    $dataItem['import_setting_id'] = (int) $import_setting_id;
                    $dataItem['available'] = $price['available'];
                    $dataItem['created_at'] = now();
                    $dataItem['updated_at'] = now();
                    $dataItem['status'] = true;
                    $data[] = $dataItem;
                } else {
                    $invalid[] = $price;
                }
            }
        }

        Log::info(json_encode($invalid));

        return $data;
    }
}
