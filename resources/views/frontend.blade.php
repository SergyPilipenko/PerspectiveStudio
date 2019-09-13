@include('frontend.partials._header')
<div id="app">
    @include('frontend.partials._pages_header')
    @yield('content')
</div>
@include('frontend.partials._footer')
