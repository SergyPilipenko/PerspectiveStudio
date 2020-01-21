<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Content\Rubric\Rubric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Partfix\QueryBuilder\Model\MysqlQueryBuilder;
use Partfix\ViewedProducts\Contracts\ViewedProductsInterface;

class RubricController extends Controller
{
    private $rubric;
    /**
     * @var ViewedProductsInterface
     */
    private $viewedProducts;
    /**
     * @var MysqlQueryBuilder
     */
    private $builder;

    public function __construct(Rubric $rubric, ViewedProductsInterface $viewedProducts, MysqlQueryBuilder $builder)
    {
        $this->rubric = $rubric;
        $this->viewedProducts = $viewedProducts;
        $this->builder = $builder;
    }

    public function index($slug)
    {
//        СТАРЫЙ КОД
        $rubric = $this->rubric->where('slug', $slug)->with('groups.categories')->firstOrFail();
//        $rubric = $this->rubric->where('slug', $slug)->firstOrFail();

        $meta_tags = [
            'rubric_title' => $rubric->title
        ];
        $locale = app()->getLocale();

        /** НУЖНО УБРАТЬ ЭТО ИЗ КОНТРОЛЛЕРА */
//        $result = $this->builder->select('rubrics as r', [
//            'distinct rg.title as rubric_title',
//            'rg.id as rubric_id',
//            'c.id as category_id',
//            'json_unquote(json_extract(c.slug, \'$."'.$locale.'"\')) as slug',
//            'json_unquote(json_extract(c.category_title, \'$."'.$locale.'"\')) as category_title',
//            'c.image',
//            'c.type'
//        ])->join('rubric_groups as rg', 'r.id', 'rg.rubric_id')
//            ->join('rubric_group_mappings as rgm','rg.id','rgm.rubric_group_id')
//            ->join('catalog_categories as c','rgm.category_id','c.id')
//            ->join('category_distinct_passanger_car_trees as cdp', 'c.id', 'cdp.category_id')
//            ->join('distinct_passanger_car_trees as dp','cdp.distinct_pct_id','dp.id')
//            ->join(env('DB_TECDOC_DATABASE').'.article_tree as art','dp.passanger_car_trees_id','art.nodeid')
//            ->join('prices as p', 'art.article_number_id', 'p.article_id')
//            ->where('r.slug', $slug)
//            ->where('p.price','0', '>')
//            ->getArrayResult();
//        $groups = $this->formatData($result);
        $activeCar = app('App\Classes\Garage')->getGarage()->activeCar ?? null;
        $viewedProducts = $this->viewedProducts->getViewedProducts();

        return view('frontend.rubrics.index', compact('rubric', 'meta_tags', 'activeCar', 'viewedProducts', 'groups'));
    }

    protected function formatData($result)
    {
        $rubrics = [];
        foreach ($result as $item) {
            $rubrics[$item['rubric_id']]['title'] = $item['rubric_title'];
            $rubrics[$item['rubric_id']]['id'] = $item['rubric_id'];
            $rubrics[$item['rubric_id']]['categories'][$item['category_id']]['id'] = $item['category_id'];
            $rubrics[$item['rubric_id']]['categories'][$item['category_id']]['slug'] = $item['slug'];
            $rubrics[$item['rubric_id']]['categories'][$item['category_id']]['title'] = $item['category_title'];
            $rubrics[$item['rubric_id']]['categories'][$item['category_id']]['image'] = $item['image'];
            $rubrics[$item['rubric_id']]['categories'][$item['category_id']]['type'] = $item['type'];
        }


        return $rubrics;
    }
}
