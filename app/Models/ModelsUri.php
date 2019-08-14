<?php

namespace App\Models;

use App\Models\Tecdoc\CarModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModelsUri extends Model
{
    protected $table = 'models_uri';

    public $timestamps = false;

    /**
     * Модели
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function model() : HasOne
    {
        return $this->hasOne(CarModel::class, 'id', 'model_id');
    }
}
