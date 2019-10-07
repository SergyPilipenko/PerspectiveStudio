<?php


namespace App\Classes\Car;


use App\Models\Tecdoc\PassangerCar;

class Car implements CarInterface
{
    public $brand, $model, $modification, $year, $modification_id;



    public function prepareData(PassangerCar $passangerCar) : self
    {
        $car = new self();
        $car->modification_id = $passangerCar->id;
        $car->brand = $passangerCar->model->brand;
        $car->model = $passangerCar->model;
        $car->modification = $passangerCar;
        $car->year = $passangerCar->year;
        $car->path = $passangerCar->getPath();
        $car->getAttributes($passangerCar);

        return $car;
    }

    public function getCars($list)
    {
        $passangerCars = PassangerCar::whereIn('id', $list->pluck('modification_id'))->with(['attributes', 'model.brand'])->get();
        $cars = [];

        foreach ($passangerCars as $passangerCar) {
            $passangerCar->year = $this->getPassangerCarYear($passangerCar->id, $list);
            $cars[] = $this->prepareData($passangerCar);
        }

        return $cars;
    }

    private function getPassangerCarYear($id, $list)
    {
        $year = null;
        foreach ($list as $item) {
            if($item['modification_id'] == $id)
            {
                $year = $item['modification_year'];
            }
        }

        return $year;
    }

    public function getAttributes($passangerCar)
    {
        $attributes = $passangerCar->getPassangerCarAttributes();
        foreach ($attributes as $key => $attribute) {
            $this->$key = $attribute;
        }
    }
}
