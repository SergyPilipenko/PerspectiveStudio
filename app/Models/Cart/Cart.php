<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model implements CartInterface
{
    protected $table = 'cart';

    public function refreshCart()
    {
        $this->items_count = $this->cartItems->count();
        $items_qty = 0;
        $grand_total = 0;
        $base_grand_total = 0;
        foreach ($this->cartItems as $cartItem) {
            $items_qty += $cartItem->quantity;
            $grand_total += $cartItem->total;
            $base_grand_total += $cartItem->total;
        }
        $this->grand_total = $grand_total;
        $this->base_grand_total = $base_grand_total;
        $this->items_qty = $items_qty;
        $this->update();
    }

    public function cartItems()
    {
        return $this->hasMany(get_class(app('App\Models\Cart\CartItemInterface')));
    }

    public function getCart()
    {
       $cart = Session::get('cart');
       if(isset($cart)) {
           $cart = $this->where('id', $cart->id)->with('cartItems.product.images')->first();
           foreach ($cart->cartItems as $cartItem) {
               $cartItem->product->name = $cartItem->product->getAttrValue('name');
           }
       }

       return $cart;
    }
}
