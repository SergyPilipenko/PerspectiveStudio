<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{

    protected $table = 'models';
    public $timestamps = false;

    public function __construct()
    {
        $this->table = env('DB_TECDOC_DATABASE').".{$this->table}";
    }

    public function modifications()
    {
        return $this->hasMany(PassangerCar::class, 'modelid', 'id');
    }

}
