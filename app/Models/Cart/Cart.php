<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model implements CartInterface
{
    protected $table = 'cart';
}
