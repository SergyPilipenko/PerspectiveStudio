<?php

namespace App\Models\Admin\Import;

use App\Models\Tecdoc\Supplier;
use Illuminate\Database\Eloquent\Model;

class SuppliersMapping extends Model
{

    protected $with = ['supplier'];

    public function supplier()
    {

        return $this->hasOne(Supplier::class, 'id', 'supplier_id');

    }
}
