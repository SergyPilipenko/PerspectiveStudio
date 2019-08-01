<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use App\Models\Tecdoc\DistinctPassangerCarTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartsController extends Controller
{
    public function index($modificationId, PartfixTecDoc $tecDoc)
    {
        $sections = $tecDoc->getNestedSections($modificationId);

        return view('frontend.parts.index', compact('sections'));
    }
}
