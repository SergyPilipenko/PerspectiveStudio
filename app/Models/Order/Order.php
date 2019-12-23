<?php

namespace App\Models\Order;

use App\Events\NewOrderEvent;
use App\Repositories\Cart\CartRepository;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements OrderInterface
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($order) {
            $cart = app('App\Models\Cart\CartInterface')->findOrFail($order->cart_id);
            $order->grand_total = $cart->grand_total;
            $order->base_grand_total = $cart->grand_total;
            $order->sub_total = $cart->grand_total;
            $order->base_sub_total = $cart->grand_total;
            $order->total_item_count = $cart->items_count;
            $order->total_qty_ordered = $cart->items_qty;
        });

        static::created(function ($order) {
            $orderItemRepository = app('App\Repositories\Order\OrderItemRepositoryInterface');
            $cartRepository = app('App\Repositories\Cart\CartRepositoryInterface');
            $productRepository = app('App\Repositories\Product\ProductRepositoryInterface');
            $cart = app('App\Models\Cart\CartInterface')->with('cartItems')->findOrFail($order->cart_id);
            $orderItems = $orderItemRepository->insert($cart->cartItems, $order);
            //Отправляет order в amoCRM
            event(new NewOrderEvent($order, $orderItems));
            $cartRepository->closeCart($cart);
        });
    }
}
