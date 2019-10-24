<?php


namespace Partfix\CatalogCategoryFilter\Contracts;


use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Catalog\Category;
use Illuminate\Support\Collection;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;

interface CategoryFilterInterface
{
    public function renderCategoryFilter(Category $category) : CategoryFilter;
    public function getCategoryFilterOptions(Collection $productIds, int $attributeId, string $attributeValueField);
    public function getAttributeValueField(Attribute $attribute);
}