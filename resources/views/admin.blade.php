<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RoyalUI Admin</title>
    @include('admin.layouts.styles')
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
                    @yield('content')
                </div>
            </div>
            @include('admin.layouts.footer')
        </div>
    </div>
</div>

@include('admin.layouts.scripts')
</body>

</html>

