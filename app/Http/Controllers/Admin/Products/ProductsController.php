<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\Prices\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\PartfixTecDoc;

class ProductsController extends Controller
{

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $prices = Price::with('articleNumber.article')->paginate(10);

        return view('admin.products.index', compact('prices'));
    }

    public function edit($price, PartfixTecDoc $tec_doc)
    {
        $price = Price::whereId($price)->with('articleNumber.article')->first();
//        dd($tec_doc->getArtCross('190130', '1'));
        return view('admin.products.edit', compact('price'));
    }
}
