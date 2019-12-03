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
            return isset($modification->modification->id) ? $this->renderTecdocFilterByModification($category, $modification->modification->id) : $this->renderTecdocFilter($category);
        }
        $productIds = $this->getFilteredProductIds($category);

        foreach ($category->filterableAttributes as $filterableAttribute) {

            $options = $this->getCategoryFilterOptions($productIds, $filterableAttribute->id, $this->getAttributeValueField($filterableAttribute), $category->id);

            $this->items[] = resolve(CategoryFilterBlock::class)->getBlock($options, $filterableAttribute);
        }

        return  $this;
    }

    public function renderTecdocFilter($category)
    {
        $attributes = $category->filterableAttributes;

        foreach ($attributes as $attribute) {
            $query = $this->builder->select(env('DB_TECDOC_DATABASE').'.article_tree as art', ['p.'.$attribute->code.' as value', 'count(*) as count'])
                ->join('products_flat as p', 'art.article_number_id', 'p.id')
                ->leftJoin('prices as pr', 'p.id', 'pr.article_id')
                ->whereIn('art.nodeid', function($query) use ($category) {
                    return $query->select('distinct_passanger_car_trees as node, distinct_passanger_car_trees as parent', ['node.passanger_car_trees_id'])
                        ->whereBetween('node._lft', 'parent._lft', 'parent._rgt')
                        ->whereIn('parent.id', function($query) use ($category) {
                            return $query->select('catalog_categories as cc', ['dc.id'])
                                ->join('category_distinct_passanger_car_trees as ct', 'cc.id', 'ct.category_id')
                                ->join('distinct_passanger_car_trees as dc', 'ct.distinct_pct_id', 'dc.id')
                                ->where('cc._lft', $category->_lft, '>=')
                                ->where('cc._rgt', $category->_rgt, '<=');
                        });
                })
                ->where('p.'.$attribute->code, '{null}', 'is not')
                ->where('pr.price', '{0}', '>')
                ->groupBy($attribute->code);

            $options = $query->getResult();
            $this->items[] = resolve(CategoryFilterBlock::class)
                ->getBlock(collect($options), $attribute);
        }

        return $this;
    }

    public function renderTecdocFilterByModification($category, $modification)
    {
        $attributes = $category->filterableAttributes;
        foreach ($attributes as $attribute) {
            $query = $category->tecdocCategoryProductsByModification($modification, array("$attribute->code as value", 'count(*) as count'))->groupBy($attribute->code);

            $options = $query->getResult();

            $this->items[] = resolve(CategoryFilterBlock::class)->getBlock(collect($options), $attribute);
        }

        return $this;
    }

    public function getCategoryFilterOptions($productIds, int $attributeId, string $attributeValueField, $categoryId)
    {
        return DB::table('category_filterable_attributes as ca')
            ->select('pv.'.$attributeValueField.' as value', DB::raw('count(*) as count'))
            ->join('product_categories as pc', 'ca.catalog_category_id', 'pc.category_id')
            ->join('product_attribute_values as pv', function ($join) {
                $join->on('pv.product_id', 'pc.product_id')->on('ca.attribute_id', 'pv.attribute_id');
            })
            ->where('ca.catalog_category_id', $categoryId)
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

    public function getCategoryTotalProductsQty(Category $category, $modification)
    {
        return $this->categoryRepository->getCategoryProductsQty($category, $modification);
    }
}
