@extends('frontend')

@section('content')
    <div class="container">
        <garage
            :garage="'{{ $garage }}'"
            :current_auto="'{{ json_encode($current_auto) }}'"
        ></garage>
        @if($categories->count())
            <ul>
                @foreach($categories as $category)
                    <li>
                        <a href="{{ route($route_name, array_merge($route_parameters, [$category->slug])) }}">{{ $category->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <h1>Category is empty</h1>
        @endif
    </div>
@endsection
