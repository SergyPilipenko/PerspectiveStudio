<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
            @if(Route::getCurrentRoute()->getPrefix() != '/checkout')
                @include('frontend.partials._cart')
            @endif
        </div>
    </div>
</div>
