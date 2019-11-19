<?php


namespace Partfix\CatalogCategoryFilter\Model;
use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Catalog\Category;
use App\Repositories\CatalogCategory\CategoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;
use Partfix\QueryBuilder\Model\MysqlQueryBuilder;


class CategoryFilter implements CategoryFilterInterface
{
    public $items = [];
    private $block;
    private $productsFilter;
    private $categoryRepository;
    private $builder;

    public function __construct(CategoryFilterBlock $block, ProductsFilter $productsFilter, CategoryRepository $categoryRepository, MysqlQueryBuilder $builder)
    {
        $this->block = $block;
        $this->productsFilter = $productsFilter;
        $this->categoryRepository = $categoryRepository;
        $this->builder = $builder;
    }


    public function renderCategoryFilter(Category $category, $modification = null) : self
    {
        if($category->type == 'tecdoc') {
            return $this->renderTecdocFilter($category, $modification);
        }
        $productIds = $this->getFilteredProductIds($category);

        foreach ($category->filterableAttributes as $filterableAttribute) {

            $options = $this->getCategoryFilterOptions($productIds, $filterableAttribute->id, $this->getAttributeValueField($filterableAttribute));

            $this->items[] = resolve(CategoryFilterBlock::class)->getBlock($options, $filterableAttribute);
        }

        return  $this;
    }

    public function renderTecdocFilter($category, $modification = null)
    {
        $attribute = Attribute::where('code', 'manufacturer')->first();


        $query = $this->builder->select(env('DB_TECDOC_DATABASE').'.article_tree as art', ['p.manufacturer as value', 'count(*) as count'])
            ->join('products as p', 'art.article_number_id', 'p.id')
            ->whereIn('art.nodeid', function($query) use ($category) {
                return $query->select('distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent', ['parent.passanger_car_trees_id'])
                    ->whereBetween('node._lft', 'parent._lft', 'parent._rgt')
                    ->whereIn('parent.id', function($query) use ($category) {
                        return $query->select('catalog_categories as cc', ['dc.id'])
                            ->join('category_distinct_passanger_car_trees as ct', 'cc.id', 'ct.category_id')
                            ->join('distinct_passanger_car_trees as dc', 'ct.distinct_pct_id', 'dc.id')
                            ->where('cc._lft', $category->_lft, '>=')
                            ->where('cc._rgt', $category->_rgt, '<=');
                    });
            })->groupBy('manufacturer');

        //        if(!$modification) {
//            $sql = "
//        SELECT pv.text_value as value, count(*) as count
//        FROM distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent
//        JOIN tecdoc2018_db.article_tree art on parent.passanger_car_trees_id = art.nodeid
//        JOIN products as p on art.article_number_id = p.id
//        JOIN product_attribute_values as pv on p.id = pv.product_id
//        JOIN attributes as a on pv.attribute_id = a.id
//        where node._lft between parent._lft and parent._rgt and parent.id in (SELECT dc.id FROM partfix.catalog_categories cc
//        JOIN category_distinct_passanger_car_trees as ct ON cc.id = ct.category_id
//        JOIN distinct_passanger_car_trees as dc on ct.distinct_pct_id = dc.id
//        where cc._lft >= {$category->_lft} and cc._rgt <={$category->_rgt})
//         and a.code = 'manufacturer'
//          ";
//        } else {
////            $sql = "
////            SELECT pv.text_value as value, count(*) as count
////            FROM distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent
////            JOIN tecdoc2018_db.article_tree art on parent.passanger_car_trees_id = art.nodeid
////            JOIN tecdoc2018_db.passanger_car_pds pds on art.productId = pds.productId and art.supplierid = pds.supplierid
////            JOIN products as p on art.article_number_id = p.id
////            JOIN product_attribute_values as pv on p.id = pv.product_id
////            JOIN attributes as a on pv.attribute_id = a.id
////            where node._lft between parent._lft and parent._rgt and parent.id in (SELECT dc.id FROM partfix.catalog_categories cc
////            JOIN category_distinct_passanger_car_trees as ct ON cc.id = ct.category_id
////            JOIN distinct_passanger_car_trees as dc on ct.distinct_pct_id = dc.id
////            where cc._lft >= {$category->_lft} and cc._rgt <={$category->_rgt})
////             and a.code = 'manufacturer' and pds.passangercarid = {$modification->modification->id}";
//            $sql = "
//            SELECT pv.text_value as value, count(distinct pv.product_id) as count FROM distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent
//            INNER JOIN tecdoc2018_db.article_tree as art ON parent.passanger_car_trees_id = art.nodeid
//            INNER JOIN products as p ON art.article_number_id = p.id
//            INNER JOIN tecdoc2018_db.passanger_car_pds as pds ON art.productId = pds.productId
//            INNER JOIN product_attribute_values pv on p.id = pv.product_id
//            INNER JOIN attributes as a on pv.attribute_id = a.id
//            WHERE node._lft
//            BETWEEN parent._lft AND parent._rgt AND parent.id IN
//            (SELECT dc.id FROM partfix.catalog_categories as cc
//            INNER JOIN category_distinct_passanger_car_trees as ct ON cc.id = ct.category_id
//            INNER JOIN distinct_passanger_car_trees as dc ON ct.distinct_pct_id = dc.id
//            WHERE cc._lft >= {$category->_lft} AND cc._rgt <= {$category->_rgt}) AND pds.passangercarid = {$modification->modification->id}
//            and a.code = 'manufacturer'";
//        }
//        if(request()->manufacturer) {
//            $sql .= " and pv.text_value = '".request()->manufacturer."'";
//        }
//        $sql .= " group by pv.text_value";
//        $cache = Cache::get(md5($sql));
//        if(!$cache) {
//            $options = DB::connection('mysql')->select($sql);
//            Cache::put(md5($sql), $options, now()->addMinutes(1));
//        } else {
//            $options = $cache;
//        }
        $options = $query->getResult();
        $this->items[] = resolve(CategoryFilterBlock::class)->getBlock(collect($options), $attribute);

        return $this;
    }

    public function getCategoryFilterOptions($productIds, int $attributeId, string $attributeValueField)
    {
        return DB::table('category_filterable_attributes as ca')
            ->select('pv.'.$attributeValueField.' as value', DB::raw('count(*) as count'))
            ->join('product_categories as pc', 'ca.catalog_category_id', 'pc.category_id')
            ->join('product_attribute_values as pv', function ($join) {
                $join->on('pv.product_id', 'pc.product_id')->on('ca.attribute_id', 'pv.attribute_id');
            })
            ->where('ca.catalog_category_id', 6)
            ->where('ca.attribute_id', $attributeId)
            ->where('pv.'.$attributeValueField, '!=', null)
            ->whereIn('pc.product_id', $productIds)
            ->groupBy('pv.'.$attributeValueField)
            ->get();
    }

    public function getFilteredProductIds($category)
    {
        return $this->categoryRepository->getCategoryProductsIds($category);
    }

    public function getAttributeValueField(Attribute $attribute) : string
    {
        return ProductAttributeValue::$attributeTypeFields[$attribute->type];
    }

    public function getCategoryProductsQtyByAttribute($categoryId, $attributeId, $attributeField, $attributeValue)
    {
        return DB::table('catalog_categories as c')
            ->select(DB::raw('count(*) as count'))
            ->join('product_categories as pc', 'c.id','pc.category_id')
            ->join('product_attribute_values as pv','pc.product_id','pv.product_id')
            ->where('c.id', $categoryId)
            ->where('pv.attribute_id', $attributeId)
            ->whereIn('pv.'.$attributeField, $attributeValue)
            ->first();
    }

    public function getCategoryTotalProductsQty(Category $category)
    {
        return $this->categoryRepository->getCategoryProductsQty($category);
    }
}
