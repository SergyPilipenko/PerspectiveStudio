<?php

namespace App\Http\Controllers\Admin\Auto;

use App\Classes\PartfixTecDoc;
use App\Models\AutoType;
use App\Models\AutoTypesPassengerCarManufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Cache;

class AutoController extends Controller
{
    public function index(PartfixTecDoc $tecDoc)
    {
        $brands = $tecDoc->getBrands();



        $auto_types = AutoType::getAll();

        $table_values = AutoTypesPassengerCarManufacturer::getTableValues();

        $auto_brands = $table_values->filtered;

        return view('admin.auto.index', compact('brands', 'auto_types', 'auto_brands', 'table_values'));
    }

    /**
     * Требуется рефактор
     * @param Request $request
     */
    public function store(Request $request)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            AutoTypesPassengerCarManufacturer::query()->delete();
            if(isset($request->auto_types) && count($request->auto_types)) {
                foreach ($request->auto_types as $manufacturer_id => $auto_type) {
                    foreach ($auto_type as $auto_type_key => $item) {
                        $passenger_cars_manufcaturers = new AutoTypesPassengerCarManufacturer();
                        $passenger_cars_manufcaturers->auto_type_id = $auto_type_key;
                        $passenger_cars_manufcaturers->manufacturer_id = $manufacturer_id;
                        $passenger_cars_manufcaturers->save();
                    }
                }
            }
            Cache::forget('admin.auto_types_passenger_car_manufacturer');
            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }

        return back();
    }

    public function getSelectedAutoBrandsManufacturers()
    {
        $selected = AutoTypesPassengerCarManufacturer::get();

        $filtered = [];
        foreach ($selected as $item) {
            $filtered[$item->manufacturer_id][] = $item->auto_type_id;
        }
        return $filtered;
    }
}
