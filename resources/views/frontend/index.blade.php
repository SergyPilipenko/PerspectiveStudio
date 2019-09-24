@extends('frontend')
@section('content')
    <div class="container">
        @if($garage)
            <div class="row">
                <garage
                    :garage="{{ $garage }}"
                    :current_auto="'{{ json_encode($current_auto) }}'"
                ></garage>
            </div>
        @endif
        <div class="row">
            <select-car :auto_brands="{{ json_encode($brands) }}"
                        :routes="'{{ json_encode($routes) }}'"
            ></select-car>
        </div>
        <h3>Категории</h3>
        @include('frontend.product-categories.categories.index', ['categories', $categories])
    </div>
@endsection
