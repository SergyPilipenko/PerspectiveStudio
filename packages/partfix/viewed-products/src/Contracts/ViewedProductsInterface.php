<?php


namespace Partfix\ViewedProducts\Contracts;


use App\Models\Admin\Catalog\Product\ProductInterface;

interface ViewedProductsInterface
{
    /**
     * Добавляет товар в список "просмотренных ранее"
     *
     * @param ProductInterface $product
     * @return mixed
     */
    public function add(ProductInterface $product);

    /**
     * Возвращает массив id просмотренных товаров
     *
     * @return array
     */
    public function getViewedProductsIds() : array;

    /**
     * Возвращает просмотренные товары
     *
     * @return mixed
     */
    public function getViewedProducts();
}
