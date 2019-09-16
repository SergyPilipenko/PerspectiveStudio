<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\CartException;
use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Cart\CartInterface;
use App\Models\Cart\CartItemInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


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

    public function add(RequestInterface $request, $id, CartRepositoryInterface $cartRepository, CartInterface $cart)
    {

        $product = $this->product->findOrFail($id);

        try {
            DB::connection()->getPdo()->beginTransaction();

            $cartRepository->add($request, $product);

            DB::connection()->getPdo()->commit();

            return $cart->getCart();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }

//        return back();
    }

    public function changeCartItemQuantity(Request $request, $id, CartItemInterface $cartItem, CartInterface $cart)
    {
        $this->validate($request, array(
            'quantity' => 'required|numeric|min:1'
        ));
        $cartItem = $cartItem->findOrFail($id);
        try {
            DB::connection()->getPdo()->beginTransaction();

            $cartItem->updateQuantity($request->quantity);

            DB::connection()->getPdo()->commit();

            return $cart->getCart();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
//        return back();
    }

    public function destroyCartItem($id, CartItemInterface $cartItem, CartInterface $cart)
    {
        $cartItem = $cartItem->findOrFail($id);

        try {
            DB::connection()->getPdo()->beginTransaction();

            $cartItem->delete();

            DB::connection()->getPdo()->commit();

            return $cart->getCart();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
    }
}
