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

    public function scopeFilter($query, $attributes)
    {

        foreach ($attributes as $key => $attribute) {
                $query->whereHas('attributes', function ($query) use ($key, $attribute) {
                    foreach ($attribute as $key => $rule) {
                        $query->where($key, $rule);
                    }
                });
        }
        return $query;
    }
}
