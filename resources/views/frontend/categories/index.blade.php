@extends('frontend')
@section('content')
    <div class="container">
        <select-car-body
            :models="'{{ json_encode($models) }}'"
            :year="'{{ Session::get('car-year') }}'"
            :actions="'{{ json_encode($routes) }}'"
        ></select-car-body>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route($brand.'.'.'frontend.categories.show', [$brand, $model, $category->slug]) }}">{{ $category->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
