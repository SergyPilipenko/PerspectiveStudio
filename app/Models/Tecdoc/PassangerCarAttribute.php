<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;

class PassangerCarAttribute extends Model
{
    protected $table = 'passanger_car_attributes';

    public function __construct()
    {
        $this->table = env('DB_TECDOC_DATABASE').".{$this->table}";
    }
}
