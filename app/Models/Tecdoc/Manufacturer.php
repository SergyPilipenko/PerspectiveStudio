<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';
    public $timestamps = false;

    public function __construct()
    {
        $this->table = env('DB_TECDOC_DATABASE').".{$this->table}";
    }

    public function models()
    {
        return $this->hasMany(CarModel::class, 'manufacturerid', 'id');
    }
}
