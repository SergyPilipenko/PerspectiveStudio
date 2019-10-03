@extends('frontend')
@section('content')
    <h1>{{ $category->title }}</h1>
    @if($children->count())
        <ul>
            @foreach($children as $child)
                <li>
                    <a href="{{ route('frontend.categories.show', [$brand, $model, $child->slug]) }}">{{ $child->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
