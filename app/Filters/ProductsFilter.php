<?php


namespace App\Filters;


class ProductsFilter extends Filters
{
    protected $filters = array(
        'article',
        'supplier',
        'model'
    );

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
}