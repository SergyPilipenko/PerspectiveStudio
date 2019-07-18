<?php

namespace App\Models\Tecdoc;

use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        return $query->where('datasupplierarticlenumber', $article)->when($query->count() > 1, function($query) use ($brand){

            $query->whereHas('supplier', function($query) use ($brand) {

                $query->where('description', $brand);

            });

        });

//        return $query->where('datasupplierarticlenumber', $article)->whereHas('supplier', function($query) use ($brand) {
//
//            $query->where('description', "{$brand}");
//
//        });

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

    public function scopeGetAticles($query,$article)
    {
        return $query->where(DB::raw("TRIM(datasupplierarticlenumber)"), $article);
    }

    public function scopeGetArticles($query, $article)
    {
        return $query->where("datasupplierarticlenumber", $article);
    }

//    public function ()
//    {
//
//    }

    public function scopeGetArticlesWithSupplier($query, $article, $brand)
    {
        $query->where('datasupplierarticlenumber', $article)->get();
    }

}
