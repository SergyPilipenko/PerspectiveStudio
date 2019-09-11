<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Catalog\Attributes\Attribute;
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
    }

    public function detail($slug)
    {
        $productId = $this->product->getProductByIdSlug($slug);
        if(!$productId) {
            abort(404);
        }

        $product = $this->product->with('attribute_family.attribute_groups.group_attributes', 'images')->findOrFail($productId);

        return view('frontend.product.show', compact('product'));
    }
}
