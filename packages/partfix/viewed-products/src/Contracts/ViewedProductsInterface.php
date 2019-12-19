<?php


namespace Partfix\ViewedProducts\Contracts;


use App\Models\Admin\Catalog\Product\ProductInterface;

interface ViewedProductsInterface
{
    public function add(ProductInterface $product);

    public function getViewedProductsIds() : array;

    public function getViewedProducts();
}
