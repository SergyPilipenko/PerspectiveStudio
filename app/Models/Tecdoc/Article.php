<?php

namespace App\Models\Tecdoc;

//use Illuminate\Database\Eloquent\Model;
use App\Models\Prices\Price;
use Awobaz\Compoships\Database\Eloquent\Model;

class Article extends Model
{
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplierId');
    }

}
