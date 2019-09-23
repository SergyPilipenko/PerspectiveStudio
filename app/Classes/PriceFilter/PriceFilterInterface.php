<?php


namespace App\Classes\PriceFilter;


use App\Models\Admin\Catalog\Product\ProductInterface;

interface PriceFilterInterface
{
    public function getProductPrice(ProductInterface $product);
}
