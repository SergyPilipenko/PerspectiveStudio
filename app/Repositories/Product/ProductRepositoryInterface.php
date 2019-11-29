<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function writeOffProductQuantity(array $orderItems);

    /**
     * Создает товары на основе данных из прайс листа
     *
     * @param $data
     * @return mixed
     */
    public function createTecdocProducts($data);
}
