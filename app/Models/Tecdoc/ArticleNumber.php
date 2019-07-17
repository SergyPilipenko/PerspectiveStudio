<?php

namespace App\Models\Tecdoc;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ArticleNumber extends Model
{
    protected $with = ['supplier'];



    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplierid');
    }

    /**
     * @param Builder $query
     * @param string $article
     * @param string|null $brand
     * @return Builder
     */
    public function scopeRelevantArticles(Builder $query, string $article, string $brand = null) : Builder
    {
        $explodeBrand = explode(' ', $brand);

        return $query->where('datasupplierarticlenumber', $article)->whereHas('supplier', function($query) use ($brand) {

            $query->where('description', "{$brand}");

        });

//            ->when($query->count() > 1, function ($query) use ($brand) {
//
//                $query->whereHas('supplier', function($query) use ($brand) {
//
//                    $query->where('description', 'like', "{$brand}%");
//
//                });



//                $query->whereHas('supplier', function($query) use ($brand) {
//
//                    $query->where('description', 'like', "%{$brand}%")
//
//                        ->when($query->count() == 0, function ($query) use ($brand){
//
//                            $query->whereHas('supplier', function($query) use ($brand) {
//
//                                $explodeBrand = explode($brand);
//
//                                $query->where('description', 'like', "%{$brand[0]}%");
//
//                            });
//
//                    });
//
//                });
//        });
    }
}
