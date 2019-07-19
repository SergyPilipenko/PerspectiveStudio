<?php

namespace App\Models\Prices;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['price', 'article_id', 'import_setting_id', 'available', 'status'];
    public static function create($fields)
    {
        $price = new self();
        $price->title = $fields['title'];
        $price->article_id = $fields['article_id'];
        $price->price = $fields['price'];
        $price->import_setting_id = $fields['import_setting_id'];
        if($price->save()) return $price;
    }

    public function scopeCreateOrUpdatePrice($query, $prices)
    {
        $keys = $this->getArticlesAndImportSettings($prices);
//        dd($prices);

        $prices_exists = $this->whereIn('article_id', $keys['articles'])
            ->whereIn('import_setting_id', $keys['import_setting_id'])->get();
        dd($prices_exists);


//        dump(count($prices));
//        dd($prices_exists->count());
//
//        if(!$prices_exists->count()) {
//            $this->insert($prices);
//        }



    }

    protected function getArticlesAndImportSettings(array $prices) : array
    {
        $data = [];

        foreach ($prices as $key => $price)
        {
            $data['articles'][] = $price['article_id'];
            $data['import_setting_id'][] = $price['import_setting_id'];
        }
        return $data;
    }
}
