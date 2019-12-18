<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RoyalUI Admin</title>
    @include('admin.layouts.styles')
    <script>var CKEDITOR_BASEPATH = '/js/libs/ckeditor/';</script>
    <script src="{{ asset('js/libs/ckeditor/ckeditor.js') }}"></script>
    <script type="application/javascript" src="{{ mix('js/admin.js') }}"></script>
</head>
<body>
<div class="container-scroller">
    @include('admin.layouts.navbar')
    <div class="container-fluid page-body-wrapper">
        @include('admin.layouts.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div id="app">
                    <div v-cloak class="main-app-container">
                        <div class="v-cloak--inline"> <!-- Parts that will be visible before compiled your HTML -->
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <flash message="{{ session('flash') }}" :errors_list="{{  json_encode($errors->messages()) }}"
                        ></flash>
                        @yield('content')
                    </div>
                </div>

            </div>
            @include('admin.layouts.footer')
        </div>
    </div>
</div>

@include('admin.layouts.scripts')
@yield('scripts')
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', () => {--}}
{{--        CKEDITOR.replace( 'editor1' );--}}
{{--    });--}}
{{--</script>--}}
</body>

</html>

