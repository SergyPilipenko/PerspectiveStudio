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
    protected $mapping = [];
    protected $articles;
    protected $errors;
    protected $upload;
    protected $save_data;

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
            $x = 0;
//            dd($rows);
            foreach ($rows as $key => $row) {
                DB::enableQueryLog();

                $this->articles = [];
                $brand = $row[$this->getColumn($import_setting,3)];

                $article = $row[$this->getColumn($import_setting,1)];
                $articles = ArticleNumber::getArticles($article)->get();

                if(!$articles->count()) {
                    $this->errors['article'][] = $article;
                    $this->upload['invalid'][] = $row;
                    continue;
                }

                if($articles->count() > 1) {

                    $filtered = $articles->filter(function($art) use ($row, $brand){
                        if($art->supplier->description == $brand || in_array($art->supplier->description, $this->mapping)) {
                            return $art;
                        };
                    });

                    if($filtered->count() < 1) {

                        $mapping =  SuppliersMapping::where('title', $brand)->first();

                        if(!$mapping) {
                            $this->errors['supplier'][] = $brand;
                            $this->upload['invalid'][] = $row;

                            continue;
                        } else {

                            if(!in_array($mapping->title, $this->mapping)) {
                                $this->mapping[] = $mapping->supplier->description;
                            }

                            $filtered = $articles->filter(function($art) use ($row, $brand, $x){

                                if($art->supplier->description == $brand || in_array($art->supplier->description, $this->mapping) ) {
                                    return $art;
                                }
                            });
                        }
                    }


                    if($filtered->count())
                    {
                        $this->upload['valid'][] = $filtered->first();
                        $this->save_data[$key]['title'] = $row[$this->getColumn($import_setting,2)];
                        $this->save_data[$key]['price'] = $row[$this->getColumn($import_setting,5)];
                        $this->save_data[$key]['article_id'] = $filtered->first()->id;
                        $this->save_data[$key]['import_setting_id'] = $import_price_id;
                    } else {

                        dd($filtered->count());
                    }

                } else {
//                    dd(34);
                }
                $x++;
            }
//            dd(DB::getQueryLog());
            dd($this);
            Price::insert($this->save_data);

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $e) {

            dd($e);
            DB::connection()->getPdo()->rollBack();
        }

        return redirect()->back();
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
