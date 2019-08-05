<?php


namespace App\Imports;


abstract class ImportFilter
{
    public function toJson()
    {

        return json_encode($this);

    }
}