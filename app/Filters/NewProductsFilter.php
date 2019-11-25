<?php


namespace App\Filters;


class NewProductsFilter extends Filters
{
    public $filters = array(
        'manufacturer'
    );

    public function apply($builder, $filterableItems = [])
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if(method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function manufacturer()
    {
        $this->builder
            ->join('product_attribute_values as pv', 'p.id', 'pv.product_id')
            ->join('attributes as a', 'pv.attribute_id', 'a.id');

    }
}
