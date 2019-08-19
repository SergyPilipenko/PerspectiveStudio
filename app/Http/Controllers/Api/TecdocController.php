<?php

namespace App\Http\Controllers\Api;

use App\Classes\PartfixTecDoc;
use App\Models\Tecdoc\PassangerCar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TecdocController extends Controller
{
    public function getBrands(PartfixTecDoc $tecDoc)
    {
        return $tecDoc->getBrands();
    }

    /**
     * @param Request $request
     * @param PartfixTecDoc $tecDoc
     * @return mixed
     */
    public function getModels(Request $request, PartfixTecDoc $tecDoc)
    {
        $this->validate($request, [
            'brand_id' => 'required'
        ]);

        return $tecDoc->getModels($request->brand_id);
    }


    /**
     * @param Request $request
     * @param PartfixTecDoc $tecDoc
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getModifications(Request $request, PartfixTecDoc $tecDoc)
    {
        $this->validate($request, [
            'model_id' => 'required'
        ]);

        return $tecDoc->getModifications($request->model_id);
    }

    /**
     * @param Request $request
     * @param PartfixTecDoc $tecDoc
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getModelsBodyTypes(Request $request, PartfixTecDoc $tecDoc)
    {
        $this->validate($request, [
            'model_Ids' => 'required'
        ]);

        return $tecDoc->getModelsBodyTypes($request->model_Ids);

    }

    /**
     * @param Request $request
     * @param PartfixTecDoc $tecDoc
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getModelsEngines(Request $request, PartfixTecDoc $tecDoc)
    {
        $this->validate($request, [
            'model_Ids' => 'required',
            'body_type' => 'required',
            'selected_year' => 'required',
        ]);

        $models = PassangerCar::with('attributes')->whereIn('modelid', explode(',',$request->model_Ids))->filter([
            [
                'attributetype' => 'BodyType',
                'displayvalue' => $request->body_type
            ]
        ])->get();

        $filtered_models = [];

        foreach ($models as $model) {
            $years = explode('-', $model->constructioninterval);

            $first = $this->getYear($years[0]);
            if(isset($years[1])) {
                $last = $this->getYear($years[1]);
            }
            if($this->validYear($request->selected_year, $first, $last)) $filtered_models[] = $model;
        }

        return $tecDoc->getModificationsEngines(
            implode(collect($filtered_models)->pluck('id')->toArray(), ','),
            $request->body_type
        );
    }

    public function getYear($str)
    {
        $value = str_replace(' ', '', $str);
        $year = preg_replace('/[0-9]+\./', '', $value);

        return $year;
    }

    public function validYear($year, $from, $to = null)
    {

        if($to) {
            if($year >= $from && $year <= $to) {

                return true;
            } return false;
        } else {
            if($year >= $from) return true;
        } return false;
    }

    public function getFilteredModifications(Request $request)
    {
        $this->validate($request, [
            'model_Ids' => 'required',
            'EngineType' => 'required',
            'BodyType' => 'required',
            'Capacity' => 'required',
        ]);

        $models = PassangerCar::whereIn('modelid', explode(',',$request->model_Ids))->with('attributes')
            ->filter([
            [
                'attributetype' => 'BodyType',
                'displayvalue' => $request->BodyType
            ],
            [
                'attributetype' => 'EngineType',
                'displayvalue' => $request->EngineType,
            ],
            [
                'attributetype' => 'Capacity',
                'displayvalue' => $request->Capacity,
            ],

        ])->get();

        if($models->count()) {
            foreach ($models as $model) {
                foreach ($model->attributes as $attribute) {
                    if($attribute->attributetype != "Power") {
                        continue;
                    } else {
                        if(preg_match (  '/PS/' , $attribute->displayvalue)) {
                            $power = preg_replace('/\D/', '',  $attribute->displayvalue);
                            $model->enginePower = $power.' л.с';
                        } else {
                            continue;
                        }
                    }
                }
            }
        }

        return $models;
    }
}
