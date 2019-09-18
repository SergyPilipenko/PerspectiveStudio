<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\RequestInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('frontend');
    }

    public function index(OrderRepositoryInterface $orderRepository)
    {
        return view('frontend.checkout.index');
    }

    public function saveOrder(Request $request, OrderRepositoryInterface $orderRepository)
    {
        $this->validate($request, array(
            'cart_id' => 'required',
            'customer_first_name' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required|email',
            'customer_last_name' => 'required',
        ));
        try {
            DB::connection()->getPdo()->beginTransaction();

            $orderRepository->saveOrder($request);

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            abort(422, $exception->getMessage());
            return;
        }
        return 'success';
    }
}
