<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\PartfixTecDoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index(PartfixTecDoc $tecdoc)
    {
        $brands = $tecdoc->getBrands();

        return view('frontend.index', compact('brands'));
    }
}
