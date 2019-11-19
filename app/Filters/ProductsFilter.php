<?php


namespace App\Filters;
use App\Models\Admin\Catalog\Attributes\Attribute;
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
    public $fillterableAttributes, $shouldBeFormattedTypes = ['decimal'];

    const MULTIPLE_VALUE_DELIMITER = ',';
    const FORMATTED_TYPE_METHOD_PREFIX = 'getFormatted';
    const _FROM = '_from';
    const _TO = '_to';


    public function __call($name, $arguments)
    {
        $attribute = $this->fillterableAttributes->where('code', $name)->first();

        if($attribute) {
            $this->attribute($attribute, array_shift($arguments));
        } else {
            $this->tryToParseAttribute($name, $arguments);
        }
    }

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
//        dd($param_value);
//        $this->builder
//            ->join('product_attribute_values as pv', 'p.id', 'pv.product_id')
//            ->join('attributes as a', 'pv.attribute_id', 'a.id')
//            ->where('a.code', $attribute->code)
//            ->whereIn('pv.'.ProductAttributeValue::$attributeTypeFields[$attribute->type], $param_value);
//        dd($param_value);

//        $this->builder->whereExists(function($query) use ($attribute, $param_value) {
//            return $query
//                ->select('product_attribute_values as pv', ['pv.'.ProductAttributeValue::$attributeTypeFields[$attribute->type]])
//                ->join('attributes as a', 'pv.attribute_id', 'a.id')
//                ->where('p.id', '{pv.product_id}')
//                ->where('a.code', $attribute->code)
//                ->whereIn('pv.'.ProductAttributeValue::$attributeTypeFields[$attribute->type], $param_value);
//        });

        return $this->builder->whereIn($attribute->code, $param_value);
    }

    protected function addCustomAttributesToFilter($filterableItems = [])
    {
        $filters = [];
        foreach ($filterableItems as $filterableItem) {
            if($this->shouldBeFormattedType($filterableItem)) {
                $method = $this->getFormatMethodName($filterableItem->type);
                $this->filters = array_merge($this->filters, $this->$method($filterableItem));
            } else {
                $this->filters = array_merge($this->filters, [$filterableItem->code]);
            }
        }

    }

    public function apply($builder, $filterableItems = [])
    {
        $this->fillterableAttributes = $filterableItems;
        $this->addCustomAttributesToFilter($filterableItems);

        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $this->$filter($value);
        }

        return $this->builder;
    }

    protected function shouldBeFormattedType($filterableItem)
    {
        return in_array($filterableItem->type, $this->shouldBeFormattedTypes) ? true : false;
    }

    protected function getFormatMethodName(string $type) : string
    {
        return self::FORMATTED_TYPE_METHOD_PREFIX.ucfirst($type);
    }

    protected function getFormattedDecimal(Attribute $filterableItem = null)
    {
        return [
            $filterableItem->code . self::_FROM,
            $filterableItem->code . self::_TO
        ];
    }
    protected function tryToParseAttribute($name, $arguments)
    {
        if(preg_match("/".self::_TO."/", $name, $matches)) {
            $method = array_shift($matches);
            $code = preg_replace("/".self::_TO."/", '', $name);
            $this->$method($code, $arguments);
        }
        if(preg_match("/".self::_FROM."/", $name, $matches)) {
            $method = array_shift($matches);
            $code = preg_replace("/".self::_FROM."/", '', $name);
            $this->$method($code, $arguments);
        }
    }

    protected function _from($code, $arguments)
    {
        $type = $this->fillterableAttributes->where('code', $code)->first()->type;
        if(!$type) return $this->builder;
        $value = array_shift($arguments);

        $this->builder->whereExists(function($query) use ($code, $value, $type) {
            return $query
                ->select('product_attribute_values as pv', ['pv.'.ProductAttributeValue::$attributeTypeFields[$type]])
                ->join('attributes as a', 'pv.attribute_id', 'a.id')
                ->where('p.id', '{pv.product_id}')
                ->where('a.code', $code)
                ->where('pv.'.ProductAttributeValue::$attributeTypeFields[$type], $value, '>=');
        });

//        return $this->builder->whereHas('attributeValues', function($query) use ($code, $value, $type) {
//            $query->join('attributes as a', 'product_attribute_values.attribute_id', 'a.id')
//                ->where('a.code', $code)
//                ->where('product_attribute_values.'.ProductAttributeValue::$attributeTypeFields[$type],'>=', $value);
//        });
    }

    protected function _to($code, $arguments)
    {
        $type = $this->fillterableAttributes->where('code', $code)->first()->type;
        if(!$type) return $this->builder;
        $value = array_shift($arguments);

        $this->builder->whereExists(function($query) use ($code, $value, $type) {
            return $query
                ->select('product_attribute_values as pv', ['pv.'.ProductAttributeValue::$attributeTypeFields[$type]])
                ->join('attributes as a', 'pv.attribute_id', 'a.id')
                ->where('p.id', '{pv.product_id}')
                ->where('a.code', $code)
                ->where('pv.'.ProductAttributeValue::$attributeTypeFields[$type], $value, '<=');
        });
//        return $this->builder->whereHas('attributeValues', function($query) use ($code, $value, $type) {
//            $query->join('attributes as a', 'product_attribute_values.attribute_id', 'a.id')
//                ->where('a.code', $code)
//                ->where('product_attribute_values.'.ProductAttributeValue::$attributeTypeFields[$type],'<=', $value);
//        });
    }
}
