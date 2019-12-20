<?php


namespace Partfix\SiteMap\model;
use Illuminate\Database\Eloquent\Model;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;

class SiteMaper extends Model
{
    /**
     * @var SQLQueryBuilder
     */
    private $builder;


    /**
     * SiteMaper constructor.
     * @param SQLQueryBuilder $builder
     */
    public function __construct(SQLQueryBuilder $builder)
    {

        $this->builder = $builder;
    }

    public function tecdocCategoryProducts()
    {
        return $this->builder->select(env('DB_TECDOC_DATABASE').'.article_tree as art', ['p.id','text_value'])
            ->join('products as p', 'art.article_number_id', 'p.id')
            ->join('product_attribute_values as pav', 'art.article_number_id', 'pav.product_id')
            ->where('pav.attribute_id','3')

            ->whereIn('art.nodeid', function($query) {
                return $query->select('distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent', ['node.passanger_car_trees_id'])
                    ->whereBetween('node._lft', 'parent._lft', 'parent._rgt')
                    ->whereIn('parent.id', function($query) {
                        return $query->select('catalog_categories as cc', ['dc.id'])
                            ->join('category_distinct_passanger_car_trees as ct', 'cc.id', 'ct.category_id')
                            ->join('distinct_passanger_car_trees as dc', 'ct.distinct_pct_id', 'dc.id')
                            ;
                    });

            })->getArrayResult();
    }
    public function getUrlWithoutCar()
    {
        return $this->builder->select(env('DB_TECDOC_DATABASE').'.manufacturers as m',['mu.slug as model_slug','muri.slug as manufacturer_slug','pc.id'])
            ->join('models_counstruction_interval as mci','m.id','mci.manufacturer_id')
            ->join('manufacturers_uri as muri','m.id','muri.manufacturer_id')
            ->join('models_uri as mu','mci.model_id','mu.model_id')

            ->join(env('DB_TECDOC_DATABASE').'.passanger_cars as pc','mci.model_id','pc.modelid')
            ->where('m.canbedisplayed', 'True')
            ->where('m.ispassengercar' , 'True')
            ->where('mci.created','1979','>')->getArrayResult();
    }
    public function getAllCategorySlug()
    {
        return $this->builder->select(' catalog_categories',['json_unquote(json_extract(slug, \'$."ru"\')) as slug'])->getArrayResult();
    }

    public function getAllCategoryUrl(){
        foreach ($this->getAllCategorySlug() as $slug){
            $category_url[] = $slug['slug'];
        }
        return $category_url;
    }
    public function getTecdocCategorySlug()
    {
        return $this->builder->select(' catalog_categories',['json_unquote(json_extract(slug, \'$."ru"\')) as slug'])
            ->where('type','tecdoc')->getArrayResult();
    }
    public function getFullUrlWithCar()
    {

        //dd($this->getUrlWithoutCar());
//dd($this->getUrlWithoutCar());
        $categories = $this->getTecdocCategorySlug();
        foreach ($this->getUrlWithoutCar() as $value) {

            foreach($categories as $slug) {


                $result_url[] = route('frontend.car.category',[$value['manufacturer_slug'],$value['model_slug'],$value['id'],$slug['slug']]);
                // $result_url[] = route('frontend.modification',[$value['manufacturer_slug'],$value['model_slug'],$value['id']]);

            }
        }
        // dd($result_url);
        return $result_url;
    }
    public function getModification(){
        foreach ($this->getUrlWithoutCar() as $value) {
            $result_url[] = route('frontend.modification',[$value['manufacturer_slug'],$value['model_slug'],$value['id']]);
        }
        return $result_url;
    }
    public  function getModel(){
        foreach ($this->getUrlWithoutCar() as $value) {
            $result_url[] = route('frontend.model',[$value['manufacturer_slug'],$value['model_slug']]);
        }
        return $result_url;
    }
    public function getFullUrl(){

        foreach ($this->tecdocCategoryProducts() as $value){
            $result_url[] = route('frontend.product.show',[$value['text_value']]);
        }
        return $result_url;
    }
    public function createFile(){

        $path ='public';

        $base_url = route('frontend.index');



        $obj = SitemapIndex::create();
        foreach ($this->getAllCategoryUrl() as $category){
            $obj->add('/'.$category ) ;
        }
        $obj->writeToFile(public_path('category_sitemap.xml'));


        $obj2 = SitemapIndex::create();

        $i = 0;
        foreach ($this->getFullUrlWithCar() as $k => $value){
            $obj2->add(str_replace($base_url,'',$value));


            if($k %10000 ==0 && $k !=0){
                $i++;
                fopen(public_path('frontend_car_category_sitemap_').$i.'.xml', "w");
                $obj2->writeToFile(public_path('frontend_car_category_sitemap_').$i.'.xml');
                $obj2 = SitemapIndex::create();
            }
        }
        $prod_count = 0;
        $obj4 = SitemapIndex::create();
        foreach ($this->getFullUrl() as $key_product => $product){
            $obj4->add(str_replace($base_url,'',$product));


            if($key_product %10000 ==0 && $key_product !=0){
                $prod_count++;
                fopen(public_path('frontend_product_show_sitemap_').$prod_count.'.xml', "w");
                $obj4->writeToFile(public_path('frontend_product_show_sitemap_').$prod_count.'.xml');
                $obj4 = SitemapIndex::create();

            }
        }
        $prod_count_modification = 0;
        //модификации
        $obj5 = SitemapIndex::create();
        foreach ($this->getModification() as $key_modification => $modification){
            $obj5->add(str_replace($base_url,'',$modification));



            if($key_modification %10000 ==0 && $key_modification !=0){
                $prod_count_modification++;
                fopen(public_path('frontend_modification_sitemap_').$prod_count_modification.'.xml', "w");
                $obj5->writeToFile(public_path('frontend_modification_sitemap_').$prod_count_modification.'.xml');
                $obj5 = SitemapIndex::create();
            }
        }
        //
        $prod_count_model = 0;
        $mod = array_unique($this->getModel());
        // dd($mod);
        $obj6 = SitemapIndex::create();
        foreach ($mod as $key_model => $model){
            $obj6->add(str_replace($base_url,'',$model));
        }
        fopen(public_path('frontend_model_sitemap_').'1'.'.xml', "w");
        $obj6->writeToFile(public_path('frontend_model_sitemap_').'1'.'.xml');

        //главный файл
        $obj3 =  SitemapIndex::create();
        $obj3->add('/category_sitemap.xml');

        for($j=1;$j<$i;$j++){
            $obj3->add('/frontend_car_category_sitemap_'.$j.'.xml');
        }
        for($a=1;$a<$prod_count;$a++){
            $obj3->add('/frontend_product_show_sitemap_'.$a.'.xml');
        }
        for($s=1;$s<$prod_count_modification;$s++){
            $obj3->add('/frontend_modification_sitemap_'.$s.'.xml');
        }

        $obj3->add('/frontend_model_sitemap_'.'1'.'.xml');

        $obj3->writeToFile(public_path('sitemap.xml'));








    }
}
