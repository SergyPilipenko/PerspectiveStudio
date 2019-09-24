<?php

use App\Models\ManufacturersUri;
use App\Models\Tecdoc\CarModel;
use App\Models\Tecdoc\Manufacturer;
use App\Models\Tecdoc\PassangerCar;
use Illuminate\Database\Seeder;

class RenameVWtoVOLKSWAGEN extends Seeder
{
    private $from = 'VW';
    private $to = 'VOLKSWAGEN';
//env('DB_DATABASE')
//env('DB_TECDOC_DATABASE')
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $volkswagenManufacturers = Manufacturer::where('matchcode', $this->from)->get();
        if(!$volkswagenManufacturers->count()) return null;
        foreach ($volkswagenManufacturers as $volkswagenManufacturer) {
            $volkswagenManufacturer->fulldescription = $this->to;
            $volkswagenManufacturer->description = $this->to;
            $volkswagenManufacturer->matchcode = $this->to;
            $volkswagenManufacturer->update();
        }
        $models = CarModel::where('manufacturerid', $volkswagenManufacturers->first()->id)->get();
        $modelIds = $models->pluck('id');
        foreach ($models as $model) {
            $model->fulldescription = preg_replace('/VW/', 'VOLKSWAGEN', $model->fulldescription, 1);
            $model->update();
        }
        $modifications = PassangerCar::whereIn('modelid', $modelIds)->get();

        foreach ($modifications as $modification) {
            $modification->fulldescription = preg_replace('/VW/', 'VOLKSWAGEN', $modification->fulldescription);
            $modification->update();
        }

        $volkswagenUri = ManufacturersUri::where('slug', $this->from)->first();
        $volkswagenUri->slug = strtolower($this->to);
        $volkswagenUri->update();
    }
}
