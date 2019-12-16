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
use Partfix\Parser\Contracts\ParserInterface;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Import\ImportByFile;
use UpdateProcuctsFlatPriceFromPrices;

class ImportController extends Controller
{

    private $builder;
    private $price;
    /**
     * все эти свойства использованы как временное решение (были проблемы с памятью), требуется рефактор кода где они используются
     * @var
     */
    private $data;
    private $fields;
    private $sql;
    private $result;
    private $updateData;
    private $invalid;
    private $dataItem;
    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(
        SQLQueryBuilder $builder,
        Price $price,
        ImportByFile $importByFile,
        ParserInterface $parser
    )
    {
        $this->middleware('auth:admin');
        $this->builder = $builder;
        $this->price = $price;
        $this->importByFile = $importByFile;
        $this->parser = $parser;
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
     * @throws \Exception
     */
    public function parse(Request $request, PriceFilter $filterSubset)
    {
        /** @var ParserInterface $csv */
        $file = ImportByFile::saveFile($request->file);
        $csv = $this->parser->csv($file, $request->delimiter)
            ->alphabetical()
            ->limit(20)
            ->get();

        $filterSubset->rows = $csv->getItems();
        $filterSubset->max_length = $csv->getMaxRowLength();

        if(request()->wantsJson()) return $filterSubset->toJson();

        return $filterSubset;



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
        $prepare = null;
        $import_setting = null;
        /** @var ParserInterface $csv */
//        $file = ImportByFile::saveFile($request->file);
//        $csv = $this->parser->csv('upload/prices/1576506571autonom_ua-84851.csv', $request->delimiter)
        $csv = $this->parser->csv('upload/prices/1576506571autonom_ua-84851.csv', ';')
            ->alphabetical()
            ->chunk(1000, function ($rows) use (&$import_setting_id, &$prepare, &$import_setting) {
                $import_setting = ImportSetting::parse($import_setting_id);
                $prepare = Price::prepareRowsToSave($rows, $import_setting);
                $this->getArticlesInTecdoc($prepare,$import_setting_id);

                Log::info(memory_get_usage());

                $prepare = null;
                $import_setting = null;
            });
        app(UpdateProcuctsFlatPriceFromPrices::class)->run();

        return redirect()->back();
    }

    /**
     * НЕ БЫЛО ВРЕМЕНИ НАПИСАТЬ НОРМАЛЬНО >:(
     *
     * @param $prices
     * @param $import_setting_id
     */
    public function  getArticlesInTecdoc(&$prices, &$import_setting_id)
    {
        $this->fields = $this->queryFields($prices);
        if(empty($this->fields)) return;
        $this->sql = "SELECT an.`id` as `article_id`, an.`datasupplierarticlenumber` as `article`,  s.description as `supplier`  FROM " . env('DB_TECDOC_DATABASE') .".`article_numbers` an
                JOIN  " . env('DB_TECDOC_DATABASE') .".suppliers s on an.`supplierid` = s.id
                WHERE (an.`datasupplierarticlenumber`, s.description) in  (";

        foreach ($this->fields as $key => $field) {
            if($key > 0) {
                $this->sql .= ', ';
            }
            $this->sql .= "('" . $field['article'] . "', '" . rtrim($field['supplier']) . "')";
        }
        $this->sql .= ')';

        $this->result = DB::connection('mysql')->select($this->sql);
        $this->result = json_decode(json_encode($this->result), true);
        Log::info(count($this->result));
//        $diff = $this->diff($this->fields, $result);
//        $valid = [];
//        $this->data = $this->updateData($prices, $this->result, $import_setting_id);
//        $this->price->createOrUpdatePrice($this->data);
        $this->data = null;
        $this->sql = null;
        $this->result = null;
        $this->fields = null;
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

    private function updateData(&$prices, &$result, &$import_setting_id)
    {
        $this->updateData = [];
        $this->invalid = [];
        foreach ($prices as &$price) {
            foreach ($result as &$item) {
                if($price['article'] == $item['article'] && $price['supplier'] == $item['supplier']) {
                    $this->dataItem = [];
                    $this->dataItem['price'] = (float) $price['price'];
                    $this->dataItem['article_id'] = $item['article_id'];
                    $this->dataItem['import_setting_id'] = (int) $import_setting_id;
                    $this->dataItem['available'] = $price['available'];
                    $this->dataItem['created_at'] = now();
                    $this->dataItem['updated_at'] = now();
                    $this->dataItem['status'] = true;
                    $this->updateData[] = $this->dataItem;
                    $this->dataItem = null;
                } else {
//                    Log::info(json_encode($price));
                }
            }
        }

        $this->invalid = null;

        return $this->updateData;
    }
}
