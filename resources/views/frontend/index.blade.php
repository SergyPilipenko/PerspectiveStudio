@extends('frontend')
@section('content')
    <div class="container">
        <div class="row">
            <garage
                :garage="'{{ $garage }}'"
                :current_auto="'{{ json_encode($current_auto) }}'"
            ></garage>
        </div>
        <div class="row">
            <select-car :auto_brands="{{ json_encode($brands) }}"></select-car>
        </div>
    </div>
@endsection
