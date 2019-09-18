<?php


namespace App\Repositories\Order;


use App\Models\Cart\CartInterface;
use Illuminate\Http\Request;
use App\Models\Order\OrderInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    private $order;

    public function __construct(OrderInterface $order, CartInterface $cart){
        $this->order = $order;
        $this->cart = $cart;
    }

    public function saveOrder(Request $request)
    {
        $this->order->cart_id = $request->cart_id;
        $this->order->customer_email = $request->customer_email;
        $this->order->customer_phone = $request->customer_phone;
        $this->order->customer_first_name = $request->customer_first_name;
        $this->order->customer_last_name = $request->customer_last_name;
        $this->order->order_comment = $request->order_comment;

        $this->order->save();
    }
}
