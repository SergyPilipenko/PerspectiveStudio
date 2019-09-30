@extends('frontend')
@section('content')
    <div class="container">
        <product-show product="{{ $product }}" add_action="{{ route('frontend.cart.add', $product->id) }}"></product-show>
        @if($product->images->count())
{{--            <div>--}}
{{--                цена: {{ $product->getAttrValue('price') }}--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                {{ $product->getAttrValue('short_description') }}--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                {{ $product->getAttrValue('description') }}--}}
{{--            </div>--}}
{{--            @foreach($product->images as $image)--}}
{{--                <img style="max-width: 100px" src="/{{ $image->path.$product->id."/".$image->name }}" alt="">--}}
{{--            @endforeach--}}
{{--            <form action="{{ route('frontend.cart.add', $product->id) }}" method="POST">--}}
{{--                @csrf--}}
{{--                <input type="hidden" name="product" value="{{ $product->id }}">--}}
{{--                <input type="hidden" name="quantity" value="1">--}}
{{--                <button class="btn btn-primary">Add to cart</button>--}}
{{--            </form>--}}
        @endif
    </div>
@endsection
