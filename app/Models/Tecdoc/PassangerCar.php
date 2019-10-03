<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Model;

class PassangerCar extends Model
{

    protected $table = 'passanger_cars';
    public $timestamps = false;


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

    public static function filterByYear($year, $models = null)
    {
        $filtered_models = [];

        if(!$models) $models = PassangerCar::where('canbedisplayed', 'true')->get();
        foreach ($models as $model) {
            $years = explode('-', $model->constructioninterval);

            $first = self::getYear($years[0]);

            if(isset($years[1])) {
                $last = self::getYear($years[1]);
            }
            if(self::validYear($year, $first, $last)) $filtered_models[] = $model;
        }

        return $filtered_models;
    }

    public static function getYear($str)
    {
        $value = str_replace(' ', '', $str);
        $year = preg_replace('/[0-9]+\./', '', $value);

        return $year;
    }

    public static function validYear($year, $from, $to = null)
    {

        if($to) {
            if($year >= $from && $year <= $to) {

                return true;
            } return false;
        } else {
            if($year >= $from) return true;
        } return false;
    }
}
