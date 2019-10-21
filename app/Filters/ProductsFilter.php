<?php


namespace App\Filters;


class ProductsFilter extends Filters
{
    protected $filters = array(
        'article',
        'supplier',
        'model',
        'brand'
    );

    private $filterableAttributes;

    public function __construct()
    {
        if(!$this->filterableAttributes) {
            $this->filterableAttributes = $this->builder->filterableAttributes->get();
        }
    }


    protected function article($article)
    {
        return $this->builder->where('datasupplierarticlenumber', 'like', "%{$article}%");
    }

    protected function supplier($supplier)
    {
        return $this->builder->whereHas('supplier', function ($query) use ($supplier) {
            $query->where('description', 'like', "%{$supplier}%");
        });
    }

    protected function brand($brand)
    {
//        return $this->builder->whereHas('attribute_value', function ($query) use ($brand){
//            $query->where('');
//        });
    }
}
