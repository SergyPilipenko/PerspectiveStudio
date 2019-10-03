<?php


namespace App\Helpers;


class Validation
{
    public static function errorExists($errors, $code)
    {
        if(isset($errors->messages()[$code])) return true;
    }
}
