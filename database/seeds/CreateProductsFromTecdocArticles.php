<?php

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

    /**
     * CreateProductsFromTecdocArticles constructor.
     */
    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($id_from = false)
    {
        $sql = "SELECT id, supplierid, datasupplierarticlenumber FROM article_numbers ";
        if($id_from) {
            $sql = $sql . "WHERE id > $id_from ";
        }
        $limit = "ORDER BY id asc limit 2000";
        $sql = $sql .  $limit;
        $articles = DB::connection('mysql_tecdoc')->select($sql);
        if(count($articles)) {
            $this->pr = [];
            foreach ($articles as $key => $article) {
                $this->last_id = $article->id;
                $this->pr[$key]['article'] = $article->datasupplierarticlenumber;
                $this->pr[$key]['id'] = $article->id;
                $this->pr[$key]['type'] = 'tecdoc';
                $this->pr[$key]['attribute_family_id'] = 38;
            }
            $this->product->insert($this->pr);
            dd('stopped');
            $this->run($this->last_id);
        }
        dd($this->last_id);
    }
}
