<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Catalog\Category;
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
        $products = Product::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.catalog.products.index', compact('products'));
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

        return redirect()->route('admin.catalog.products.edit', $this->product->id);
    }

    public function edit($product_id, Category $category)
    {
        $product = $this->product->with('attribute_family.attribute_groups.group_attributes', 'images', 'categories')->findOrFail($product_id);

        $categories = $category->get()->toTree();

        return view('admin.catalog.products.edit', compact('product', 'categories'));
    }

    public function update(ProductForm $request, $id)
    {
        $product = $this->product->productUpdate($request->all(), $id);

        Session::flash('flash', 'Новые данные были сохранены успешно');

        return back();
    }

    public function destroy($id, Product $product)
    {
        $product->with('images')->findOrFail($id)->delete();

        Session::flash('flash', 'Товар был удален успешно');

        return back();
    }
}
