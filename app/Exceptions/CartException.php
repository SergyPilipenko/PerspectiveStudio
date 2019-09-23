<?php

namespace App\Exceptions;

use Exception;

class CartException extends Exception
{
    public static function make($quantity)
    {
        return new static("Доступное количество товара - $quantity");
    }

    public static function invalidPrice($price)
    {
        return new static ("Некорректная цена - $price");
    }
}
