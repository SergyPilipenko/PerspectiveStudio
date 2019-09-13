<?php


namespace App\Repositories\Cart;
use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Cart\CartInterface;
use App\Models\Cart\CartItemInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Support\Facades\Session;

class CartRepository implements CartRepositoryInterface
{
    private $cart;
    private $session_cart;
    private $approved = false;
    private $cartItems = [];
    /**
     * @var CartItemInterface
     */
    private $cartItem;

    public function __construct(CartInterface $cart, CartItemRepository $cartItem)
    {
        $this->cart = $cart;
        $this->cartItem = $cartItem;
    }

    public function create(RequestInterface $request, ProductInterface $product)
    {
//        $product_price = $product->getAttrValue('price');
//        $this->cart->items_count = $request->quantity;
//        $this->cart->items_qty = $request->quantity;
//        $this->cart->grand_total = $request->quantity * $product_price;
//        $this->cart->base_grand_total = $request->quantity * $product_price;
        $this->cart->save();
        $this->approved = true;
    }
    public function add(RequestInterface $request, ProductInterface $product)
    {
        $this->session_cart = Session::get('cart');
        if(!$this->session_cart) {
            $this->create($request, $product);
            $this->session_cart = $this->cart;
            Session::put('cart', $this->session_cart);
        };
        if(!$this->approved) {
            $this->cart = $this->cart->find($this->session_cart->id);
        }

        $this->cartItem->add($request, $product, $this->cart);
    }

    public function refresh()
    {

    }
    public function reset() {}
}
