@extends('frontend')
@section('content')
    <div class="container">
        <div class="row">
            <checkout :app_cart="'{{ $cart  = app('App\Models\Cart\CartInterface')->getCart() }}'">
                @if($cart)
                    <div slot="content">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    @if(!auth()->user())
                                        @include('frontend.checkout.checkout-user-info-form')
                                    @endif
                                </div>
                                <div class="row">
                                    @include('frontend.checkout.checkout-order-comment')
                                </div>
                            </div>
                            <div class="col-md-4">
                                @include('frontend.checkout.cart', ['cart' => $cart])
                            </div>
                        </div>
                    </div>
                @endif
            </checkout>
        </div>
    </div>
@endsection
