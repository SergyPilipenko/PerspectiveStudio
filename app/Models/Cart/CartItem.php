<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model implements CartItemInterface
{
    protected $table = 'cart_items';

    protected static function boot()
    {
        parent::boot();

        static::updated(function($cartItem) {
            $cartItem->cart->refreshCart();
        });
    }

    public function cart()
    {
        return $this->belongsTo(get_class(app('App\Models\Cart\CartInterface')));
    }
}
