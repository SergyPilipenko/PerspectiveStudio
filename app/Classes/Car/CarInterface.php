<?php


namespace App\Classes\Car;


use App\Models\Tecdoc\PassangerCar;

interface CarInterface
{
    public function getCars($list);

    public function prepareData(PassangerCar $passangerCar) : Car;
}
