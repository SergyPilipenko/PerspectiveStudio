<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Garage;
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

    public function detail($slug, CartInterface $cart, ProductInterface $product, Garage $garage)
    {
        $cart = $cart->getCart();
        /** @var Product $product */
        $product = $product->getProduct($slug);
        $garage = $garage->getGarage();
        if(!$garage->empty()) {
            $car = $garage->getSessionActiveCar();
            $belongsModification = $product->belongsModification($car['modification_id']);
        }
//        dd($garage->empty());

        return view('frontend.product.show', compact('product', 'cart', 'belongsModification', 'garage'));
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
