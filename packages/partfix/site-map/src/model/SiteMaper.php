<?php


namespace Partfix\SiteMap\model;
use Illuminate\Database\Eloquent\Model;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;

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
            ->limit(10)
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
    public function getCategorySlug()
    {
        return $this->builder->select(' catalog_categories',['json_unquote(json_extract(slug, \'$."ru"\')) as slug'])->getArrayResult();
    }
    public function getCategoryUrl(){
        foreach ($this->getCategorySlug() as $slug){

        }
    }
    public function getFullUrlWithoutCar()
    {
       // dd($this->getCategorySlug());
//dd($this->getUrlWithoutCar());
            foreach ($this->getUrlWithoutCar() as $value) {
               // foreach($this->getCategorySlug() as $slug) {


//                $result_url[] = route('frontend.car.category',[$value['manufacturer_slug'],$value['model_slug'],$value['id'],$slug['slug']]);
                $result_url[] = route('frontend.modification',[$value['manufacturer_slug'],$value['model_slug'],$value['id']]);

           // }
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
        $urlset = new \SimpleXMLElement('<?urlset version="1.0" encoding="UTF-8"?><urlset/>');
        foreach($this->getFullUrlWithoutCar() as $link){
            $url = $urlset->addChild('url');
           $loc =  $url->addChild('loc');
           $loc['url'] = $link;
        }
        dd($urlset->asXML());
    }
}
