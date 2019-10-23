<?php


namespace App\Filters;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;
use Illuminate\Http\Request;


class ProductsFilter extends Filters
{
    public $filters = array(
        'article',
        'supplier',
        'model',
        'brand'
    );

    const MULTIPLE_VALUE_DELIMITER = ',';


    public function __call($name, $arguments)
    {
        $attribute = $this->fillterableAttributes->where('code', $name)->first();
        if($attribute) {
            $this->attribute($attribute, array_shift($arguments));
        }
    }


    public $fillterableAttributes;

//    public function __construct()
//    {
//        if(!$this->filterableAttributes) {
//            $this->filterableAttributes = $this->builder->filterableAttributes->get();
//        }
//    }


    protected function article($article)
    {
        return $this->builder->where('article', 'like', "%{$article}%");
    }

    protected function supplier($supplier)
    {
        return $this->builder->whereHas('supplier', function ($query) use ($supplier) {
            $query->where('description', 'like', "%{$supplier}%");
        });
    }

    protected function attribute($attribute, $attributeValue)
    {
        $param_value = explode(self::MULTIPLE_VALUE_DELIMITER, $attributeValue);
        return $this->builder->whereHas('attributeValues', function($query) use ($attribute, $param_value) {
            $query->join('attributes as a', 'product_attribute_values.attribute_id', 'a.id')
                ->where('a.code', $attribute->code)
                ->whereIn('product_attribute_values.'.ProductAttributeValue::$attributeTypeFields[$attribute->type], $param_value);
        });
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value) {
            $this->$filter($value);
        }

        return $this->builder;
    }

    protected function brand($brand)
    {
//        return $this->builder->whereHas('attribute_value', function ($query) use ($brand){
//            $query->where('');
//        });
    }
}
