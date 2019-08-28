<?php

namespace App\Models;

use App\Models\Tecdoc\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Cache;

class AutoType extends Model
{

    public function manufacturers()
    {
        return $this->hasMany(AutoTypesPassengerCarManufacturer::class, 'auto_type_id', 'id');
    }

    public function passenger_cars_manufcaturers()
    {
        return $this->hasMany(AutoTypesPassengerCarManufacturer::class, 'auto_type_id', 'id');
    }

    public function scopeBrands($query)
    {
        return $query->with('manufacturers.manufacture');
    }


    public function scopeGetAll($query)
    {
        if(!Cache::get('admin.auto_types')) {
            Cache::rememberForever('admin.auto_types', function () use ($query) {
                return $query->get();
            });
        } return Cache::get('admin.auto_types');
    }

}
