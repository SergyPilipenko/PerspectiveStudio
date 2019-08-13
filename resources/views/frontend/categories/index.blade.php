@extends('frontend')
@section('content')
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('frontend.categories.show', [$brand, $model, $category->slug]) }}">{{ $category->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
