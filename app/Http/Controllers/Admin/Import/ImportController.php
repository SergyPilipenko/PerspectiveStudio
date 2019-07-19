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
    protected $mapping = [];
    protected $articles;
    protected $errors;
    protected $upload;
    protected $save_data;
    protected $supplier;

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

    public function import_price(Request $request, $import_setting_id)
    {
        $rows = $request->type::import($request);

        $import_setting = ImportSetting::parse($import_setting_id);
//        dd($rows);
        try {
            DB::connection()->getPdo()->beginTransaction();
            $x = 0;
            foreach ($rows as $key => $row) {
                DB::enableQueryLog();

                $this->articles = [];
                $brand = $row[$import_setting->columns['supplier']];
                $article = $row[$import_setting->columns['article']];
                $articles = ArticleNumber::getArticles($article)->get();

                if(!$articles->count()) {
                    $this->errors['article_not_found'][] = $article;
                    $this->upload['invalid'][$key]['row'] = $row;
                    $this->upload['invalid'][$key]['errors'][] = 'article_not_found';
                    $supplier = Supplier::where('description', $brand)->first();
                    if(!$supplier) {
                        $this->upload['invalid'][$key]['errors'][] = 'supplier_not_found';
                    }

//                    dd(Supplier::where('description', $brand)->first());

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
                            $this->errors['supplier_not_found'][] = $brand;
//                            $this->upload['invalid'][] = $row;
                            $this->upload['invalid'][$key]['row'] = $row;
                            $this->upload['invalid'][$key]['errors'][] = 'supplier_not_found';
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
                        $this->save_data[$key]['price'] = $row[$import_setting->columns['price']];
                        $this->save_data[$key]['article_id'] = $filtered->first()->id;
                        $this->save_data[$key]['import_setting_id'] = $import_setting_id;
                        $this->save_data[$key]['available'] = (int) $row[$import_setting->columns['available']];
                        $created_at = Carbon::now();
                        $this->save_data[$key]['created_at'] = $created_at;
                        $this->save_data[$key]['updated_at'] = $created_at;
                        $this->save_data[$key]['status'] = true;
                    } else {

                        dd($filtered->count());
                    }

                } else {
//                    dd(34);
                }
                $x++;
            }

            if(isset($this->upload['invalid'])) {
                InvalidPrice::saveInvalidPrices($this->upload['invalid'], $import_setting);
            }
            if(isset($this->save_data)) {
                Price::createOrUpdatePrice($this->save_data);
            }


//            $history = new UploadHistory();
//            $history->price_upload_success_count = count($this->upload['valid']);
//            $history->price_upload_fails_count = count($this->upload['invalid']);
//            $history->import_setting_id = $import_price_id;
//            $history->save();
//            dd($this);
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
}
