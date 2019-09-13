<?php

namespace App\Models\Cart;

use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model implements CartInterface
{
    protected $table = 'cart';

    protected $repository;


    public function refreshCart()
    {
        dd($this);
//        $this->repository->refresh();
    }

    public function cartItems()
    {
        return $this->hasMany(get_class(app('App\Models\Cart\CartItemInterface')));
    }
}
