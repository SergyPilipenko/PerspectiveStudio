<?php


namespace App\Classes;

use Session;
use Exception;

class Garage
{
    const GARAGE = 'garage';
    const MODIFICATION_ID = 'modification_id';
    const MODIFICATION_YEAR = 'modification_year';
    const CURRENT_AUTO = 'current-auto';
    const CURRENT_CAR_YEAR = 'car-year';

    private $garage;

    private $session;

    public function __construct()
    {
        $this->session = session();
    }

    /**
     * Добавить машину (модификацию в гараж)
     *
     * @param int $modification
     * @param null $year
     */
    public function addCarToGarage(int $modification, $year = null)
    {
        $this->session->push(self::GARAGE, [
            self::MODIFICATION_ID => $modification,
            self::MODIFICATION_YEAR => $year ?? $this->getSelectedYear()
        ]);
    }

    /**
     * Активная машина
     *
     * @param $modification
     * @param null $year
     */
    public function setActiveCar(int $modification, $year = null)
    {
        if($this->carInGarage($modification) == false) {
            $this->addCarToGarage($modification, $year);
        }


        \Session::put(self::CURRENT_AUTO, [
            self::MODIFICATION_ID => $modification,
            self::MODIFICATION_YEAR => $year ?? $this->getSelectedYear()
        ]);
    }

    public function getActiveCar()
    {
        return Session::get(self::CURRENT_AUTO);
    }



    public function removeCar($id)
    {
        $garage = Session::get(self::GARAGE);
        $current_auto = $this->getActiveCar();

        foreach ($garage as $key => $car) {
            if($car[self::MODIFICATION_ID] == $id) {
                Session::forget(self::GARAGE.'.'."$key");
            }
        }
        if($current_auto[self::MODIFICATION_ID] == $id && $this->getGarageList()->count()) {
            $new_current_auto = $this->getGarageList()->first();
            $this->setActiveCar($new_current_auto[self::MODIFICATION_ID], $new_current_auto[self::MODIFICATION_YEAR]);
        }
//        throw new Exception("Car id '".$id."' does not exist in garage");
    }

    /**
     * Список машин в гараже
     *
     * @return \Illuminate\Support\Collection
     */
    public function getGarageList()
    {
        return collect(Session::get(self::GARAGE));
    }

    public function setCurrentYear($year)
    {
        return Session::put(self::CURRENT_CAR_YEAR, $year);
    }

    /**
     * Текущий выбранный год
     * @return mixed
     */
    protected function getSelectedYear()
    {
        return Session::get(self::CURRENT_CAR_YEAR);
    }

    public function clear()
    {
        $this->clearCarYear();
        $this->clearGarage();
        $this->clearActiveCar();
    }

    protected function clearGarage()
    {
        return Session::forget(self::GARAGE);
    }

    protected function clearActiveCar()
    {
        return Session::forget(self::CURRENT_AUTO);
    }

    protected function clearCarYear()
    {
        return Session::forget(self::CURRENT_CAR_YEAR);
    }

    protected function carInGarage($modification)
    {
        foreach ($this->getGarageList() as $item) {
            if($item[self::MODIFICATION_ID] == $modification) return true;
        }
        return false;
//        if($this->getGarageList()->count()) {
//            $this->getGarageList()->pluck(self::MODIFICATION_ID)->contains(function ($value) use ($modification) {
//                return $value == $modification;
//            });
//        } return false;
    }
}
