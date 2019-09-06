<?php

namespace App\Models\Admin\Catalog\Product;

use App\Http\Requests\ProductForm;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['path', 'product_id'];

    public function uploadImages(ProductForm $request, Product $product)
    {
//        dd($product);

        $previousImageIds = $product->images()->pluck('id');

        if(isset($request->img) && isset($request->img[0])) {
            foreach ($request->img as $key => $image) {
                $file_name = time() . $image->getClientOriginalName();
                $file_path = 'upload/img/product/' . $product->id . '/';
                $image->move($file_path, $file_name);

//                $file = time() . $image->getClientOriginalName();
//                $dir = 'product/' . $product->id;
                $this->create([
                    'path' => $file_path . $file_name,
                    'product_id' => $product->id
                ]);
            }
        }
    }
}
