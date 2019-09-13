<?php


namespace App\Repositories\Cart;


use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Cart\CartItemInterface;

interface CartRepositoryInterface
{
    public function create(RequestInterface $request, ProductInterface $product);
    public function add(RequestInterface $request, ProductInterface $product);
    public function reset();
    public function refresh();
}
