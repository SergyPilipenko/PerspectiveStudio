<div class="container">
    <div class="row">
        <div class="col-md-9">
            <search :add_action="'{{ route('frontend.cart.add', PRODUCT_MARK_FOR_REPLACING) }}'"
                    :marker="'{{ PRODUCT_MARK_FOR_REPLACING }}'"></search>
        </div>
        <div class="col-md-3">
            @if(Route::getCurrentRoute()->getPrefix() != '/checkout')
                @include('frontend.partials._cart')
            @endif
        </div>
    </div>
</div>
