<?php

namespace App\Http\Controllers\Admin\Import;

//use App\Article;
use App\Helpers\Routes;
use App\Imports\PriceFilter;
use App\Models\Admin\Import\ImportByUrl;
use App\Models\Admin\Import\ImportColumn;
use App\Models\Admin\Import\ImportSetting;
use App\Models\Admin\Import\SuppliersMapping;
use App\Models\Prices\Price;
use App\Models\Tecdoc\ArticleNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;


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
        $columns = ImportColumn::all();

        return view('admin.import.create', [
            'routes' => json_encode($routes->getRoutesByName('admin.import')),
            'columns' => $columns
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

        $import_setting = json_decode(ImportSetting::find($import_price_id)->scheme);

        $info = [];

        try {
            DB::connection()->getPdo()->beginTransaction();
            foreach ($rows as $row) {
                $mapping = SuppliersMapping::where('title', $row[$this->getColumn($import_setting,3)])->first();
                $supplier = $mapping ? $mapping->supplier_id : null;
                dd($supplier);

//                dd($mapping);

                $query = ArticleNumber::where('datasupplierarticlenumber', $row[$this->getColumn($import_setting,1)])

                    ->whereHas('supplier', function ($query) use ($row,$import_setting, $mapping) {

                        $query->where('description', $row[$this->getColumn($import_setting,3)])

                            ->orWhere('id', $mapping);

                })->first();


                if($query) {
                    $info['saved'][] = Price::create([
                        'title' => $row[$this->getColumn($import_setting,2)],
                        'article_id' => $query->id,
                        'price' => $row[$this->getColumn($import_setting,5)],
                        'import_setting_id' => $import_price_id
                    ]);

                } else {
//                    $mapping = SuppliersMapping::where('title', $row[$this->getColumn($import_setting,3)])->first();

//                    if($mapping) {
////                        Price::create([]);
//                    } else {
//
//
//
//                    }

                    $info['not_found'] = $row;
                    dd($row);
                }
            }
            DB::connection()->getPdo()->commit();
        } catch (\PDOException $e) {

            dd($e);
            DB::connection()->getPdo()->rollBack();
        }

        dd($info);


//        $query = ArticleNumber::whereIn('datasupplierarticlenumber', $articles)
//            ->whereHas('supplier', function($query) use ($brands) {
//                $query->whereIn('description', ['MAHLE ORIGINAL']);
//            })->get();
//        if($query->count() > 0) {
//            $prices[] = $query;
//        } else {
//            $notFount[] = $row;
//        }
//
//        dump($query);
//        dd($notFount);

//        ArticleNumber::whereIn('datasupplierarticlenumber', $articles)->whereHas('supplier', function($query) use ($brands) {
//            $query->whereIn('description', $brands);
//        })->get();
//
//        dd($notFount);

        return redirect()->back();
//        dd();

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

    public function getColumn($scheme, $needle)
    {
        foreach ($scheme as $item) {
            if($item->value == $needle) return $item->column;
        }
    }
}
