<?php

namespace App\Http\Controllers\Api;

use App\Classes\PartfixTecDoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TecdocController extends Controller
{
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
}
