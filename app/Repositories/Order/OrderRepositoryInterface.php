<?php


namespace App\Repositories\Order;


use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function saveOrder(Request $request);
}
