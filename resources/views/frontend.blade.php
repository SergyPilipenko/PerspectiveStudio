@include('frontend.partials._header')
<div id="app" v-cloak>
    @include('frontend.partials._pages_header')
    @yield('content')
</div>
@include('frontend.partials._footer')
