<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;

class PassangerCar extends Model
{

    protected $table = 'passanger_cars';


    public function __construct()
    {
        $this->table = env('DB_TECDOC_DATABASE').".{$this->table}";
    }

    public function attributes()
    {
        return $this->hasMany(PassangerCarAttribute::class, 'passangercarid', 'id');
    }
}
