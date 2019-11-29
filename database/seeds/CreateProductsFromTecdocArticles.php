<?php

use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Tecdoc\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use App\Models\Admin\Catalog\Product\Product;

class CreateProductsFromTecdocArticles extends Seeder
{
    private $last_id;
    private $products;
    private $pr;
    private $tecdoc_attribute_family_id;
    private $total = 0;
    private $iteration = 0;
    private $partCount = 2000;

    /**
     * CreateProductsFromTecdocArticles constructor.
     */
    public function __construct()
    {
        $this->product = new Product();
        $this->tecdoc_attribute_family_id = AttributeFamily::where('code', 'tecdoc')->first()->id;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($id_from = false)
    {
        if(!$id_from) {
            $this->product->where('attribute_family_id', $this->tecdoc_attribute_family_id)->delete();
            $this->total = DB::connection('mysql_tecdoc')->selectOne("select count(*) as total FROM article_numbers")->total;
        }

        $sql = "SELECT id, supplierid, datasupplierarticlenumber FROM article_numbers ";
        if($id_from) {
            $sql = $sql . "WHERE id > $id_from ";        
	    }
	
        $limit = "ORDER BY id asc limit {$this->partCount}";
        $sql = $sql .  $limit;
        $articles = DB::connection('mysql_tecdoc')->select($sql);
        if(count($articles)) {
            $this->pr = [];
            foreach ($articles as $key => $article) {
                $this->last_id = $article->id;
                $this->pr[$key]['article'] = $article->datasupplierarticlenumber;
                $this->pr[$key]['id'] = $article->id;
                $this->pr[$key]['type'] = 'tecdoc';
                $this->pr[$key]['attribute_family_id'] = $this->tecdoc_attribute_family_id;
            }
            $this->product->insert($this->pr);
            $this->iteration += count($articles);
            echo "{$this->iteration}/{$this->total}\n";
            $this->run($this->last_id);
        }
    }
}

//Нагружает комп
//DB::table(env('DB_TECDOC_DATABASE').".article_numbers")
//    ->orderBy('id')
//    ->chunk(2000, function ($items) {
//        $products = [];
//        foreach ($items as $item)
//        {
//            $product = [];
//            $product['article'] = $item->datasupplierarticlenumber;
//            $product['id'] = $item->id;
//            $product['type'] = 'tecdoc';
//            $product['attribute_family_id'] = $this->tecdoc_attribute_family_id;
//            $products[] = $product;
//        }
//        $this->product->insert($products);
//
//    });
