<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Categories\Category;
use App\Models\Content\Rubric\Rubric;
use App\Models\Content\Rubric\RubricGroup;
use Illuminate\Http\Request;
use Partfix\QueryBuilder\Model\MysqlQueryBuilder;
use Partfix\SiteMap\model;
use App\Http\Controllers\Controller;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;
use Partfix\ViewedProducts\Contracts\ViewedProductsInterface;


class MobileMenuController extends Controller
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
    public function index(\Partfix\SiteMap\model\SiteMaper $siteMaper,RubricGroup $rubrics,Category $category,Rubric $rub){
        $rubric = $this->rubric->with('groups.categories')->get();
        $category_rubric = RubricGroup::all();
        //$rubric = Rubric::all()->with('groups.categories')->firstOrFail();
       // dd($rubric);
       /* $all_rubric =$this->builder->select('rubrics',['slug','title']  )->getArrayResult();
        $all_rubrics =$this->builder->select('rubric_groups',['title']  )

            ->getArrayResult();*/

      // $rubric =  $siteMaper->getRubric();
        $msg = 'ку-ку';
          // dd($rubric);
        foreach ($rubric as $key=> $rubric_item){


           $result_rubric[$key]['link'] = '#';
           $result_rubric[$key]['title'] = $rubric_item->title;

            //dd($rubric_item->groups);
            //$result_rubric['children'] = [$rubric_item];
           foreach ($rubric_item->groups as $group_key => $group){

                  // $rubric_id = $rubric_item->id;
                  // dd($rubric_id);
               $all_rubric['title'] = $group->title;
               $all_rubric['link'] = '#';


                   //$result['children'][$key]['children'] = $all_rubric;

                   foreach ($group->categories as $k=> $category){
                       $groups[$k]['title'] = $category->category_title;
                       $groups[$k]['link'] = route('frontend.product-categories.show', $category->slug);
                       $groups[$k]['image'] = asset($category->image);
                      // $all_rubric['title'] = $category->category_title;
                      // $all_rubric['link'] = route('frontend.product-categories.show', $category->slug);

                       $categori['title'] = $category->category_title;

                       $categori['link'] = route('frontend.product-categories.show', $category->slug);

                       //$group['children'][$k]= [];



                        // $cat['title'] = $categ['title'];


                         $categori[$k]['children'] = [];

                       $groups[$k]['children'] =$categori;
                   }

               $all_rubric['children'] = $groups;
               $result_rubric[$key]['children'][] = $all_rubric;
               // $result[$key]['children'] = $all_rubric;

           }

            $result = $result_rubric;



        }
//dd($group->categories);
        return response()->json(array('msg'=> $result), 200);
    }
    //
}
