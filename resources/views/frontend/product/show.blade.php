<h1>{{ $product->getAttrValue('name') }}</h1>
@if($product->images->count())
    @foreach($product->images as $image)
        <img src="/{{ $image->path.$product->id."/".$image->name }}" alt="">
    @endforeach
@endif
