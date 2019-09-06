<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Session;
use App\Http\Requests\ProductForm;

class ProductsController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return view('admin.catalog.products.index');
    }

    public function create(AttributeFamily $attributeFamily)
    {
        $attributes_families = $attributeFamily->get();

        return view('admin.catalog.products.create', compact('attributes_families'));
    }

    public function store(Request $request)
    {

        $this->validate($request, array(
            'type' => 'required',
            'attribute_family' => 'required|exists:attribute_families,id',
            'article' => 'required|unique:products,article'
        ));

        $this->product->article = $request->article;
        $this->product->type = $request->type;
        $this->product->attribute_family_id = $request->attribute_family;
        $this->product->save();

        Session::flash('flash', 'Новый товар было создан успешно');

        return redirect()->route('admin.catalog.products.edit', $this->product);
    }

    public function edit($product_id)
    {
        $product = $this->product->with('attribute_family.attribute_groups.attributes')->findOrFail($product_id);

        return view('admin.catalog.products.edit', compact('product'));
    }

    public function update(ProductForm $request, $id)
    {
        $this->product->productUpdate($request->all(), $id);
//        dd($this->product->update(request()->all(), $id));
    }

    public function destroy()
    {

    }
}
