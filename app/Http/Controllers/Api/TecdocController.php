<?php

namespace App\Http\Controllers\Api;

use App\Classes\PartfixTecDoc;
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
        ]);

        return $tecDoc->getModelsEngines($request->model_Ids, $request->body_type);
    }
}
