<?php


namespace Partfix\CatalogCategoryFilter\Model;

use App\Models\Admin\Catalog\Attributes\Attribute;
use Illuminate\Support\Collection;

class CategoryFilterBlock
{
    public $attribute;
    private $options;

    public function getBlock(Collection $options, Attribute $attribute)
    {
        $this->attribute = $attribute;
        $this->options = $options;

        return $this;
    }

    public function getTitle()
    {
        if(isset($this->attribute)) {
            return $this->attribute->title;
        }
    }

    public function getOptions()
    {
        return $this->options;
    }
}
