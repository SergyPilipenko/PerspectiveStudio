@if(Route::getCurrentRoute()->getPrefix() != '/checkout')
        @include('frontend.partials._default_pages_header')
    @else
        @include('frontend.partials._checkout_pages_header')
@endif
