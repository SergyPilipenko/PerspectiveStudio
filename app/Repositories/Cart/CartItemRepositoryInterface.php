<?php


namespace App\Repositories\Cart;


use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Cart\CartInterface;

interface CartItemRepositoryInterface
{
    public function add(RequestInterface $request, ProductInterface $product, CartInterface $cart);
}
