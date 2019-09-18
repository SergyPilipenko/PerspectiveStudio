<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function writeOffProductQuantity(array $orderItems);
}
