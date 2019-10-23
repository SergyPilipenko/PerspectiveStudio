<?php


namespace Partfix\CatalogCategoryFilter\Model;
use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;
use Partfix\CatalogCategoryFilter\Model\CategoryFilterBlock;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;


class CategoryFilter implements CategoryFilterInterface
{
    public $items = [];
    private $block;

    public function __construct(CategoryFilterBlock $block)
    {
        $this->block = $block;
    }


    public function renderCategoryFilter(Category $category) : self
    {
        foreach ($category->filterableAttributes as $filterableAttribute) {
            $options = $this->getCategoryFilterOptions($filterableAttribute->id, $this->getAttributeValueField($filterableAttribute));
            $this->items[] = resolve(CategoryFilterBlock::class)->getBlock($options, $filterableAttribute);
        }

        return  $this;
    }

    public function getCategoryFilterOptions(int $attributeId, string $attributeValueField)
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
            ->groupBy('pv.'.$attributeValueField)
            ->get();
    }

    public function getAttributeValueField(Attribute $attribute) : string
    {
        return ProductAttributeValue::$attributeTypeFields[$attribute->type];
    }
}
