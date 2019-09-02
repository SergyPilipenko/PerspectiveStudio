<?php

use App\Models\ManufacturersUri;
use App\Models\Tecdoc\CarModel as Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ModelsUri;

class AddModelsSlug extends Seeder
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

            $models = Model::all();

            foreach ($models as $model) {
                $model_uri = new ModelsUri;
                $model_uri->model_id = $model->id;
                $model_name = explode(' ',$model->description);
                $model_name = preg_replace('/-/', '_', $model_name);
                $model_name = Transliterate::make(mb_strtolower(array_shift($model_name)));
                $model_uri->slug = $model_name;
                $model_uri->manufacturer_id = $model->manufacturerid;
                $model_uri->save();
            }

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
    }
}
