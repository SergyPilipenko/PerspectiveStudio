<?php

namespace App\Models\Prices;

use App\Models\Admin\Import\ImportSetting;
use App\Models\Admin\Import\InvalidPrice;
use App\Models\Admin\Import\SuppliersMapping;
use App\Models\Tecdoc\ArticleNumber;
use App\Models\Tecdoc\Supplier;
use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Price extends Model
{
    protected $fillable = ['price', 'article_id', 'import_setting_id', 'available', 'status'];

    protected $mapping = [];
    protected $articles;
    protected $errors;
    protected $upload;
    protected $save_data;
    protected $supplier;
    /** @var ProductRepositoryInterface */
    private $productRepository;


    public function __construct(array $attributes = [])
    {
        $this->productRepository = resolve(ProductRepositoryInterface::class);
        parent::__construct($attributes);
    }

    public function articleNumber()
    {
        return $this->hasOne(ArticleNumber::class, 'id', 'article_id');
    }

    public function importSetting()
    {
        return $this->belongsTo(ImportSetting::class);
    }

    public static function create($fields)
    {
        $price = new self();
        $price->title = $fields['title'];
        $price->article_id = $fields['article_id'];
        $price->price = $fields['price'];
        $price->import_setting_id = $fields['import_setting_id'];
        if($price->save()) return $price;
    }

    public function scopeCreateOrUpdatePrice(Builder $query, array $prices)
    {
        foreach ($prices as $price) {
            $this->updateOrCreate(
                [
                    'article_id' => $price['article_id'],
                    'import_setting_id' => $price['import_setting_id']
                ],
                [
                    'price' => $price['price'],
                    'available' => $price['available'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'status' => $price['status'] ?? false
                ]
            );
        }
    }

    public static function prepareRowsToSave(array $rows, ImportSetting $import_setting) : array
    {
        $prices = [];
        foreach ($rows as $key => $row) {
            $prices[$key]['article'] = $row[$import_setting->columns['article']];
            $prices[$key]['supplier'] = $row[$import_setting->columns['supplier']];
            $prices[$key]['price'] = $row[$import_setting->columns['price']];
            $prices[$key]['available'] = $row[$import_setting->columns['available']];
        }
        return $prices;
    }

    public function scopeSavePrices(Builder $query, $prices, ImportSetting $import_setting)
    {

            $x = 0;

            foreach ($prices as $key => $price) {

                $this->articles = [];
                $brand = $price['supplier'];
                $article = $price['article'];
                $articles = ArticleNumber::getArticles($article)->get();
                if(!$articles->count()) {
                    $this->errors['article_not_found'][] = $article;
                    $this->upload['invalid'][$key]['row'] = $price;
                    $this->upload['invalid'][$key]['errors'][] = 'article_not_found';
                    $supplier = Supplier::where('description', $brand)->first();
                    $mapping = SuppliersMapping::where('title', $brand)->first();
                    if(!$supplier && !$mapping) {
                        $this->upload['invalid'][$key]['errors'][] = 'supplier_not_found';
                    }

                    continue;
                }

                if($articles->count() >= 1) {

                    $filtered = $articles->filter(function($art) use ($price, $brand){
                        if($art->supplier->description == $brand || in_array($art->supplier->description, $this->mapping)) {
                            return $art;
                        };
                    });

                    if($filtered->count() < 1) {

                        $mapping =  SuppliersMapping::where('title', $brand)->first();

                        if(!$mapping) {
                            $this->errors['supplier_not_found'][] = $brand;
                            $this->upload['invalid'][$key]['row'] = $price;
                            $this->upload['invalid'][$key]['errors'][] = 'supplier_not_found';
                            continue;
                        } else {

                            if(!in_array($mapping->title, $this->mapping)) {
                                $this->mapping[] = $mapping->supplier->description;
                            }

                            $filtered = $articles->filter(function($art) use ($price, $brand, $x){
                                if($art->supplier->description == $brand || in_array($art->supplier->description, $this->mapping) ) {
                                    return $art;
                                }
                            });
                            if(!$filtered->count()) {
                                $this->errors['article_not_found'][] = $article;
                                $this->upload['invalid'][$key]['row'] = $price;
                                $this->upload['invalid'][$key]['errors'][] = 'article_not_found';
                                continue;
                            }
                        }
                    }

                    if($filtered->count())
                    {
                        $this->upload['valid'][] = $filtered->first();
                        $this->save_data[$key]['price'] = (float) $price['price'];
                        $this->save_data[$key]['article_id'] = $filtered->first()->id;
                        $this->save_data[$key]['import_setting_id'] = $import_setting->id;
                        $this->save_data[$key]['available'] = (int) $price['available'];
                        $created_at = Carbon::now();
                        $this->save_data[$key]['created_at'] = $created_at;
                        $this->save_data[$key]['updated_at'] = $created_at;
                        $this->save_data[$key]['status'] = true;
                    } else {

                        $this->errors['supplier_not_found'][] = $brand;
                        $this->upload['invalid'][$key]['row'] = $price;
                        $this->upload['invalid'][$key]['errors'][] = 'supplier_not_found';
                        continue;
                    }

                } else {
                    continue;
                }
                $x++;

            }

        if(isset($this->upload['invalid'])) {
                InvalidPrice::saveInvalidPrices($this->upload['invalid'], $import_setting);
        }
        if(isset($this->save_data)) {
            $query->createOrUpdatePrice($this->save_data);
            $this->productRepository->createTecdocProducts($this->save_data);
        }
    }
}
