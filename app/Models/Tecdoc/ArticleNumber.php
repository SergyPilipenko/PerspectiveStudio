<?php

namespace App\Models\Tecdoc;

use App\Classes\PartfixTecDoc;
use App\Models\Prices\Price;
use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ArticleNumber extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'article_numbers';

    public function __construct()
    {
        $this->table = env('DB_TECDOC_DATABASE').".{$this->table}";
    }

    protected $with = ['supplier'];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplierid');
    }

    public function article()
    {
        return $this->hasOne(Article::class, ['supplierId','DataSupplierArticleNumber'], ['supplierid', 'datasupplierarticlenumber']);
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'article_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
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
    }

    public function scopeGetAticles($query,$article)
    {
        return $query->where(DB::raw("TRIM(datasupplierarticlenumber)"), $article);
    }

    public function scopeGetArticles($query, $article)
    {
        return $query->where("datasupplierarticlenumber", $article);
    }
    public function scopeGetArticlesWithSupplier($query, $article, $brand)
    {
        $query->where('datasupplierarticlenumber', $article)->get();
    }

}
