@extends('frontend')
@section('content')
    <div class="container">
{{--        @json($models)--}}
        <select-car-body
            :models="{{ $models }}"
            :year="'{{ Session::get('car-year') }}'"
            :actions="'{{ json_encode($routes) }}'"
        ></select-car-body>
{{--        <ul>--}}
{{--            @foreach($categories as $category)--}}
{{--                <li>--}}
{{--                    <a href="{{ route('frontend.category', [$brand, $model]) }}">{{ $category->title }}</a>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
    </div>
@endsection
