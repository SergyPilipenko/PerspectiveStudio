<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model implements CartItemInterface
{
    protected $table = 'cart_items';
}
