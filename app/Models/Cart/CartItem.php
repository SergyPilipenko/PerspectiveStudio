<?php

namespace App\Models\Cart;

use App\Exceptions\CartException;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model implements CartItemInterface
{
    protected $table = 'cart_items';

    protected static function boot()
    {
        parent::boot();

        static::creating(function($cartItem) {
            $product = $cartItem->product;
            $product_quantity = $product->quantity;
            if($cartItem->quantity > $product_quantity && $product->depends_quantity == false) {
                throw CartException::make($product_quantity);
            }
            $cartItem->refreshTotal();
        });

        static::created(function ($cartItem) {
            $cartItem->cart->refreshCart();
        });

        static::updating(function($cartItem) {
            $product = $cartItem->product;
            $product_quantity = $product->quantity;

            if($cartItem->quantity > $product_quantity && $product->depends_quantity == false) {
                throw CartException::make($product_quantity);
            }
            $cartItem->refreshTotal();
        });

        static::updated(function($cartItem) {
            $cartItem->cart->refreshCart();
        });

        static::deleted(function($cartItem) {
            $cartItem->cart->refreshCart();
        });
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->update();
    }

    public function refreshTotal()
    {
        $this->total = $this->price * $this->quantity;
        $this->base_total = $this->price * $this->quantity;
    }

    public function cart()
    {
        return $this->belongsTo(get_class(app('App\Models\Cart\CartInterface')));
    }

    public function product()
    {
        return $this->belongsTo(get_class(app('App\Models\Admin\Catalog\Product\ProductInterface')));
    }
}
