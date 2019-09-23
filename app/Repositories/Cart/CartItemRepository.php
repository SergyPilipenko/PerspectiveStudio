<?php


namespace App\Repositories\Cart;


use App\Exceptions\CartException;
use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Cart\CartInterface;
use App\Models\Cart\CartItemInterface;

class CartItemRepository implements CartItemInterface
{

    /**
     * @var CartItemInterface
     */
    private $cartItem;
    private $productInCart;
    private $cartException;

    public function __construct(CartItemInterface $cartItem)
    {
        $this->cartItem = $cartItem;
    }

    public function add(RequestInterface $request, ProductInterface $product, CartInterface $cart)
    {
        if($this->productExistInCart($product->id, $cart->id)) {
            return $this->updateProductItemQuantity($request, $product);
        }

        $this->cartItem->article = $product->getAttrValue('article');

        $price = $product->getPrice();
        if($price <= 0) {
            throw CartException::invalidPrice($price);
        }

        $this->cartItem->name = $product->getAttrValue('name');
        $this->cartItem->type = $product->type;
        $this->cartItem->quantity = $request->quantity;
        $this->cartItem->price = $price;
        $this->cartItem->base_price = $price;
        $this->cartItem->product_id = $product->id;
        $this->cartItem->cart_id = $cart->id;
        $this->cartItem->save();

        return $this->cartItem;
    }

    protected function updateProductItemQuantity(RequestInterface $request, ProductInterface $product)
    {
        $this->productInCart->quantity += (int) $request->quantity;
        $price = $product->getAttrValue('price');
        $this->productInCart->total = $this->productInCart->quantity * $price;
        $this->productInCart->base_total = $this->productInCart->quantity * $price;
        $this->productInCart->update();
    }

    protected function productExistInCart(int $product_id, int $cart_id)
    {
        $product_item = $this->cartItem->where([
            'product_id' => $product_id,
            'cart_id' => $cart_id
        ])->first();
        if(isset($product_item)) {
            $this->productInCart = $product_item;
            return true;
        };
    }
}
