<?php

namespace App\Models\Tecdoc;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class PassangerCarTree extends Model
{
    use Compoships;

    protected $table = 'passanger_car_trees';

    public function __construct()
    {
        $this->table = env('DB_TECDOC_DATABASE').".{$this->table}";
    }
}
