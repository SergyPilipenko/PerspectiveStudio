<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->middleware('frontend');
        $this->product = $product;
    }

    public function add(RequestInterface $request, $id, CartRepositoryInterface $cartRepository)
    {

        $product = $this->product->findOrFail($id);


        $cartRepository->add($request, $product);


        return back();
    }
}
