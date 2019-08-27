<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoType extends Model
{
    public function passenger_cars_manufcaturers()
    {
        return $this->hasMany(AutoTypesPassengerCarManufacturer::class, 'auto_type_id', 'id');
    }

}
