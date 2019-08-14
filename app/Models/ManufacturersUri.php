<?php

namespace App\Models;

use App\Models\Tecdoc\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManufacturersUri extends Model
{
    protected $table = 'manufacturers_uri';

    public $timestamps = false;

    /**
     * Производители
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manufacturers() : HasMany
    {
        return $this->hasMany(Manufacturer::class, 'id', 'manufacturer_id');
    }

    /**
     * Производители пассажирских авто
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passangercar() : HasMany
    {
        return $this->manufacturers()->where('ispassengercar', 'true');
    }
}
