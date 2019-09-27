<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Cart\CartInterface;
use App\Search\Searchers\CategoriesSearcher;
use App\Search\Searchers\ProductsSearcher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Catalog\Product\Product;

class ProductController extends Controller
{

    protected $product, $attribute;

    public function __construct(Product $product, Attribute $attribute)
    {
        $this->product = $product;
        $this->attribute = $attribute;
        $this->middleware('frontend');
    }

    public function detail($slug, CartInterface $cart, ProductInterface $product)
    {
        $cart = $cart->getCart();

//        $productId = $this->product->getProductByIdSlug($slug);
//        if(!$productId) {
//            abort(404);
//        }

//        $product = $this->product->with('attribute_family.attribute_groups.group_attributes', 'images')->findOrFail($productId);
//        $product->price = $product->getPrice();
//
//
//        $attributes = $product->getProductAttributes();
//        $product->custom_attributes = $product->getProductAttributes();
        $product = $product->getProduct($slug);
//        dd($product);


        return view('frontend.product.show', compact('product', 'cart'));
    }

    public function search(Request $request, ProductsSearcher $productsSearcher, CategoriesSearcher $categoriesSearcher)
    {
        $this->validate($request, array(
            'searchString' => 'required|min:3'
        ));
        $response['categories'] = $categoriesSearcher->search($request->searchString);
        $response['products'] = $productsSearcher->search($request->searchString);

        return $response;
    }
}
