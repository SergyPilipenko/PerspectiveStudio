<accordian>
    <div slot="header">Изображения</div>
    <div slot="body">
        <product-images-upload :images_list="'{{ $product->images }}'" :path="'{{ $product->productImage->path }}'"></product-images-upload>
    </div>
</accordian>
