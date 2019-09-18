<?php


namespace App\Repositories\Order;


use App\Models\Order\OrderInterface;
use App\Models\Order\OrderItemInterface;
use Carbon\Carbon;

class OrderItemRepository
{
    /**
     * @var OrderItemInterface
     */
    private $orderItem;

    public function __construct(OrderItemInterface $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function insert($cartItems, OrderInterface $order)
    {
        $data = [];
        foreach ($cartItems as $key => $cartItem) {
            $data[$key]['article'] = $cartItem->article;
            $data[$key]['type'] = $cartItem->type;
            $data[$key]['name'] = $cartItem->name;
            $data[$key]['type'] = $cartItem->type;
            $data[$key]['qty_ordered'] = $cartItem->quantity;
            $data[$key]['price'] = $cartItem->price;
            $data[$key]['base_price'] = $cartItem->base_price;
            $data[$key]['total'] = $cartItem->total;
            $data[$key]['base_total'] = $cartItem->base_total;
            $data[$key]['product_id'] = $cartItem->product_id;
            $data[$key]['order_id'] = $order->id;
            $data[$key]['created_at'] = Carbon::now();
            $data[$key]['updated_at'] = Carbon::now();
        }

        $this->orderItem->insert($data);

        return $data;
    }
}
