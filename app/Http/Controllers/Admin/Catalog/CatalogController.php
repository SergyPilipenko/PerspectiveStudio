<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Classes\PartfixTecDoc as Tecdoc;
use App\Models\Admin\Import\ImportColumn;
use App\Models\Admin\Import\ImportSetting;
use App\Models\Admin\Import\InvalidPrice;
use App\Models\Admin\Import\SuppliersMapping;
use App\Models\Prices\Price;
use App\Models\Tecdoc\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\Routes;
use Session;

class CatalogController extends Controller
{
    public function index()
    {
        $settings = ImportSetting::with(['importErrors', 'prices'])->paginate(15);

        return view('admin.catalog.index', compact('settings'));
    }

    /**
     * @param ImportSetting $import_setting
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function diagnostics(ImportSetting $import_setting)
    {
        $protuct_errors = $import_setting->importErrors()->orderBy('created_at', 'desc')->paginate(5);
        $suppliers = Supplier::all();
        $prices_count = $import_setting->prices()->count();

        return view('admin.catalog.diagnostics', compact('import_setting', 'protuct_errors', 'suppliers', 'prices_count'));
    }

    public function prices(ImportSetting $import_setting)
    {
        $prices = $import_setting->prices()->with('articleNumber.article')->get();

        return view('admin.catalog.prices', compact('import_setting', 'prices'));
    }

    /**
     * @param $import_setting_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalogErrors(string $import_setting_id)
    {
        $setting = ImportSetting::with('importErrors.errors')->find($import_setting_id);
        $columns = ImportColumn::all();
        $suppliers = Supplier::orderBy('description', 'asc')->get();

        return view('admin.catalog.errors.index', compact(['setting', 'columns','suppliers']));
    }

    /**
     * @param ImportSetting $import_setting
     * @param Routes $routes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(ImportSetting $import_setting, Routes $routes)
    {
        $routes = json_encode($routes->getRoutesByName('admin.import'));

        return view('admin.catalog.settings', compact('import_setting', 'routes'));
    }

    /**
     * @param Request $request
     * @param ImportSetting $importSetting
     * @return bool
     */
    public function update(Request $request, ImportSetting $importSetting)
    {
        $this->validate($request, [
            'title' => 'required',
            'type' => 'required'
        ]);
        $importSetting->title = $request->title;
        $importSetting->update();
        $importSetting->importable->updateImportByUrl($request);
        return $importSetting;
    }

    public function addMapping(Request $request, $setting_id, SuppliersMapping $suppliersMapping)
    {
        $this->validate($request, [
            'mapping' => 'required',
            'supplier' => 'required'
        ]);

        if(!$suppliersMapping->where('title', $request->supplier)->first()) {
            try {
                DB::connection()->getPdo()->beginTransaction();

                $mapping = $suppliersMapping->create([
                    'supplier_id' => $request->mapping,
                    'supplier' => $request->supplier,
                    'import_setting_id' => $setting_id
                ]);

                $invalid_prices = InvalidPrice::where('supplier', $request->supplier)
                    ->where('import_setting_id', $setting_id)
                    ->with('errors')
                    ->whereHas('errors', function($query) {
                    $query->error = 'supplier_not_found';
                })->get();

                $import_setting = ImportSetting::parse($setting_id);

                InvalidPrice::destroy($invalid_prices->pluck('id'));

                Price::savePrices($invalid_prices->toArray(), $import_setting);

//                dd(1);
                DB::connection()->getPdo()->commit();
            } catch (\PDOException $e) {

                DB::connection()->getPdo()->rollBack();
            }


        } else {
            $invalid_prices = InvalidPrice::where('supplier', $request->supplier)->where('import_setting_id', $setting_id)->get();
            dd($invalid_prices);
            throw new \Exception('test');
        }

        $setting = ImportSetting::find($setting_id);
    }

    public function destroy($id)
    {
        ImportSetting::findOrFail($id)->delete();

        Session::flash('flash', 'Схема загрузки была удалена');

        return redirect()->route('admin.catalog.index');
    }
}
