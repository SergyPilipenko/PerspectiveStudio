<?php


namespace App\Classes;

use App\Classes\Car\CarInterface;
use App\Models\AutoType;
use Illuminate\Support\Facades\Session;

class Garage
{
    const GARAGE = 'garage';
    const MODIFICATION_ID = 'modification_id';
    const MODIFICATION_YEAR = 'modification_year';
    const CURRENT_AUTO = 'current-auto';
    const CURRENT_CAR_YEAR = 'car-year';

    private $garage = [];
    private $car;
    public $cars;
    public $activeCar;
    public $checkedBrands;

    private $session;
    /**
     * @var PartfixTecDoc
     */
    private $tecDoc;

    public function __construct(CarInterface $car, PartfixTecDoc $tecDoc)
    {
        $this->session = session();
        $this->car = $car;
        $this->tecDoc = $tecDoc;
    }

    public function empty()
    {
        $list = $this->getGarageList();
        if(!$list->count()) return true;

        return false;
    }

    public function getGarage()
    {
        $list = $this->getGarageList();

        if(count($list) && !$this->cars) {
            $this->cars = collect($this->car->getCars($list));
            $this->activeCar = $this->getActiveCar();
        }

        return $this;
    }



    /**
     *
     * @param int $modification
     * @param null $year
     */
    public function addCarToSessionGarageList(int $modification, $year = null)
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
        if(!$this->getSelectedYear()) return;

        if($this->carInGarage($modification) == false) {
            $this->addCarToSessionGarageList($modification, $year);
        }


        Session::put(self::CURRENT_AUTO, [
            self::MODIFICATION_ID => $modification,
            self::MODIFICATION_YEAR => $year ?? $this->getSelectedYear()
        ]);
    }

    public function getActiveCar()
    {
        if($this->cars && $this->cars->count())
        {
            $active = $this->getSessionActiveCar();
            foreach ($this->cars as $car)
            {
                if($car->modification_id == $active['modification_id'])
                {
                    return $car;
                }
            }
        }
    }

    public function getSessionActiveCar()
    {
        return Session::get(self::CURRENT_AUTO);
    }



    public function removeCar($id)
    {
        $garage = Session::get(self::GARAGE);
        $current_auto = $this->getSessionActiveCar();

        foreach ($garage as $key => $car) {
            if($car[self::MODIFICATION_ID] == $id) {
                Session::forget(self::GARAGE.'.'."$key");
                if(!$this->getGarageList()->count()) return;
            }
        }

        if($current_auto[self::MODIFICATION_ID] == $id && $this->getGarageList()->count()) {
            $new_current_auto = $this->getGarageList()->first();

            $this->setActiveCar($new_current_auto[self::MODIFICATION_ID], $new_current_auto[self::MODIFICATION_YEAR]);
        }
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

    public function getCheckedBrands()
    {
        return $checkedBrands ?? $this->tecDoc->getCheckedBrands(AutoType::where('code', 'cars')->first()->id);
    }
}
