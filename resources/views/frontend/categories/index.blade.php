@extends('frontend')
@section('content')
    <div class="container">
        <select-car-body
            :models="'{{ $models }}'"
            :year="'{{ Session::get('car-year') }}'"
            :actions="'{{ json_encode(['set-car-year' => route('set-car-year')]) }}'"
        ></select-car-body>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('frontend.categories.show', [$brand, $model, $category->slug]) }}">{{ $category->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
