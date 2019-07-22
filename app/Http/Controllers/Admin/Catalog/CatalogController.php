<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Models\Admin\Import\ImportColumn;
use App\Models\Admin\Import\ImportSetting;
use App\Models\Admin\Import\InvalidPrice;
use App\Models\Admin\Import\SuppliersMapping;
use App\Models\Prices\Price;
use App\Models\Tecdoc\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
    public function show(ImportSetting $import_setting)
    {
        return view('admin.catalog.show', compact('import_setting'));
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

                $invalid_prices = InvalidPrice::where('supplier', $request->supplier)->where('import_setting_id', $setting_id)->get();
                $import_setting = ImportSetting::parse($setting_id);
                InvalidPrice::destroy($invalid_prices->pluck('id'));
                $save = Price::savePrices($invalid_prices->toArray(), $import_setting);

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
}
