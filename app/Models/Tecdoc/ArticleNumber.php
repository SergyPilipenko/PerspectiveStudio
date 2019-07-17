<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;

class ArticleNumber extends Model
{
    protected $with = ['supplier'];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplierid');
    }
}
