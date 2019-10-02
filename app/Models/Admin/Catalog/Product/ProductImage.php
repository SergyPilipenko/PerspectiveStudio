<?php

namespace App\Models\Admin\Catalog\Product;

use App\Http\Requests\ProductForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['path', 'product_id', 'name'];

    public $path = 'upload/img/product/';

    public function uploadImages(ProductForm $request, Product $product)
    {

        $previousImages = $product->images;
        $requestedImagesList = json_decode($request->imagesList, true);

        if(isset($request->img)) {
            foreach ($request->img as $key => $image) {
                $file_name = time() . $image->getClientOriginalName();
                $file_path = $this->path . $product->id . '/';
                $image->move($file_path, $file_name);
                $this->create([
                    'path' => $file_path . $file_name,
                    'product_id' => $product->id,
                    'name' => $file_name
                ]);
            }
        }
        if($previousImages->count()) {
            foreach ($previousImages as $image) {
                if(!$this->imgNameExists($requestedImagesList, $image->name)) {
                    File::delete($this->getProductImagePath($product, $image->name));
                    $image->delete();
                }
            }
        }

    }

    protected function getProductImagePath($product, $imageName)
    {
        return $this->path . $product->id . '/' . $imageName;
    }

    protected function imgNameExists($requestedImagesList, $image)
    {
        if(count($requestedImagesList)) {
            foreach ($requestedImagesList as $requestedImage) {
                if(isset($requestedImage['name']) && $requestedImage['name'] == $image) return true;
            }
        } return false;

    }
}
