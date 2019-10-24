<?php


namespace Partfix\CatalogCategoryFilter\Model;
use App\Filters\ProductsFilter;
use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Catalog\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;


class CategoryFilter implements CategoryFilterInterface
{
    public $items = [];
    private $block;
    private $productsFilter;

    public function __construct(CategoryFilterBlock $block, ProductsFilter $productsFilter)
    {
        $this->block = $block;
        $this->productsFilter = $productsFilter;
    }


    public function renderCategoryFilter(Category $category) : self
    {
        $productIds = $this->getFilteredProductIds($category);

        foreach ($category->filterableAttributes as $filterableAttribute) {
            $options = $this->getCategoryFilterOptions($productIds, $filterableAttribute->id, $this->getAttributeValueField($filterableAttribute));
            $this->items[] = resolve(CategoryFilterBlock::class)->getBlock($options, $filterableAttribute);
        }

        return  $this;
    }

    public function getCategoryFilterOptions(Collection $productIds, int $attributeId, string $attributeValueField)
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
        return $category->products()
            ->with('productAttributeValues')
            ->filter($this->productsFilter, $category->filterableAttributes)->get()->pluck('id');
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

    public function getFilterQty($categoryId, $data)
    {
//        $data = json_decode($data, true);
//        $qty = 0;
//
//        if(count($data)) {
//            foreach ($data as $attribute) {
//                $qty += $this->getCategoryProductsQtyByAttribute(
//                    $categoryId,
//                    $attribute['id'],
//                    ProductAttributeValue::$attributeTypeFields[$attribute['type']],
//                    $attribute['value']
//                )->count;
//            }
//        } else {
//            $qty = $this->getCategoryTotalProductsQty($categoryId);
//        };

//        return $qty;
    }

    public function getCategoryTotalProductsQty(Category $category)
    {
        return $category->products()
            ->with('productAttributeValues')
            ->filter($this->productsFilter, $category->filterableAttributes)->count();
//        return DB::table('product_categories')->where('category_id', $categoryId)->count();
    }
}
