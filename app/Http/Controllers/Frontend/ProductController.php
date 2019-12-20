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
use Partfix\ViewedProducts\Contracts\ViewedProductsInterface;

class ProductController extends Controller
{

    protected $product, $attribute;
    /**
     * @var ViewedProductsInterface
     */
    private $viewedProducts;

    public function __construct(Product $product, Attribute $attribute, ViewedProductsInterface $viewedProducts)
    {
        $this->product = $product;
        $this->attribute = $attribute;
        $this->viewedProducts = $viewedProducts;
        $this->middleware('frontend');
    }

    public function detail($slug, CartInterface $cart, ProductInterface $product, Garage $garage)
    {
        $cart = $cart->getCart();
        /** @var Product $product */
        $product = $product->getProduct($slug);
        $product->features = $product->getTecdocProductFeatures();
//        dd($product->features);
        $garage = $garage->getGarage();
        $meta_tags = [
            'part' => $product->custom_attributes['name'],
            'manufacturer' => $product->custom_attributes['manufacturer'],
            'article' => $product->article
        ];

        if(!$garage->empty()) {
            $car = $garage->getSessionActiveCar();
            $belongsModification = $product->belongsModification($car['modification_id']);
            $activeCar = $garage->getActiveCar();
        }
        $this->viewedProducts->add($product);
        $viewedProducts = $this->viewedProducts->getViewedProducts();

        return view('frontend.product.show', compact('product', 'cart', 'belongsModification', 'garage', 'meta_tags', 'activeCar', 'viewedProducts'));
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
