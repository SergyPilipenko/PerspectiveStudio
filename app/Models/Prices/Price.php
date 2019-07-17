<?php

namespace App\Models\Prices;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public static function create($fields)
    {

        $price = new self();
        $price->title = $fields['title'];
        $price->article_id = $fields['article_id'];
        $price->price = $fields['price'];
        $price->import_setting_id = $fields['import_setting_id'];

        if($price->save()) return $price;
    }
}
