<?php

use App\Models\Tecdoc\PassangerCar;
use Illuminate\Database\Seeder;
use App\Models\Tecdoc\ModelConstrucitonInterval;

class AddModelsConstructionIntervalTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::connection()->getPdo()->beginTransaction();

            $models = PassangerCar::where('canbedisplayed', 'true')->get();

            foreach ($models as $model) {
                $years = explode('-', $model->constructioninterval);
                dd($model);

                $first = PassangerCar::getYear($years[0]);
                $last = PassangerCar::getYear($years[1]);

                $model_construction_interval = new ModelConstrucitonInterval;
                $model_construction_interval->created_at = $first;
                $model_construction_interval->model_id = $model->id;
                $model_construction_interval->manufacturerid = $model->manufacturerid;
                $model_construction_interval->stopped_at = $last;
                $model_construction_interval->save();
            }

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
    }
}
