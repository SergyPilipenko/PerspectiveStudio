@extends('frontend')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @if(!auth()->user())
                        @include('frontend.checkout.checkout-user-info-form')
                    @endif
                    @include('frontend.checkout.checkout-order-comment')
                </div>
            </div>
            <div class="col-md-4">
                @include('frontend.checkout.cart')
            </div>
        </div>
    </div>
@endsection
