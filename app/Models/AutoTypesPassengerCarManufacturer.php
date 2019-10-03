<?php

namespace App\Models;

use App\Models\Tecdoc\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Cache;

class AutoTypesPassengerCarManufacturer extends Model
{
    protected $table = 'auto_types_passenger_cars_manufacturers';

    public $filtered = [];
    public $headCheck = [];

    public function manufacture()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id')->where('ispassengercar', 'true');
    }

    public function scopeGetTableValues($query) : AutoTypesPassengerCarManufacturer
    {
        if(!Cache::get('admin.auto_types_passenger_car_manufacturer')) {
            Cache::rememberForever('admin.auto_types_passenger_car_manufacturer', function () use ($query) {
                return $query->get();
            });
        }
        $selected = Cache::get('admin.auto_types_passenger_car_manufacturer');

        if($selected->count()) {
            foreach ($selected as $item) {
                if(!isset($this->headCheck[$item->auto_type_id])) {
                    $this->headCheck[$item->auto_type_id] = 0;
                } $this->headCheck[$item->auto_type_id]++;
                $this->filtered[$item->manufacturer_id][] = $item->auto_type_id;
            }
        }


        return $this;
    }
}
