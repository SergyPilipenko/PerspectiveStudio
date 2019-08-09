@extends('frontend')
@section('content')
    <div class="container">
        <div class="row">
            <select-car :auto_brands="{{ json_encode($brands) }}"></select-car>
        </div>
    </div>
@endsection
