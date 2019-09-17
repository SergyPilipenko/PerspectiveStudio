<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('frontend');
    }

    public function index()
    {
        return view('frontend.checkout.index');
    }
}
