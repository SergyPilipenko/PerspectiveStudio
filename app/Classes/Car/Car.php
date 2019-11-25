<?php


namespace App\Classes\Car;


use App\Classes\Garage;
use App\Models\Tecdoc\PassangerCar;
use Illuminate\Support\Facades\Session;

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
//        echo $passangerCar->getPath();
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

    public function getCar($modification)
    {
        $passangercar = PassangerCar::where('id', $modification)->with(['attributes', 'model.brand'])->first();
        $car = $this->prepareData($passangercar);
        $sessionActiveCar = $this->getSessionActiveCar();
        if(isset($sessionActiveCar[Garage::MODIFICATION_ID]) && isset($sessionActiveCar[Garage::MODIFICATION_ID]) && $sessionActiveCar[Garage::MODIFICATION_ID] == $passangercar->id) {
            $car->year = $sessionActiveCar[Garage::MODIFICATION_YEAR];
        }

        return $car;
    }

    public function formatCapacity($capacity)
    {
        return number_format(preg_replace('/[^0-9\.,]/', '',$capacity), 1);
    }


    public function getSessionActiveCar()
    {
        return Session::get(Garage::CURRENT_AUTO);
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
