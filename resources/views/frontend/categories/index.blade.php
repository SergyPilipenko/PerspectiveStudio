@extends('frontend')
@section('content')
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('frontend.categories.show', [$modification, $category->slug]) }}">{{ $category->title }}</a>
            </li>
        @endforeach
    </ul>
    {{--    @if(count($sections) > 0)--}}
    {{--        <ul>--}}
    {{--            @foreach($sections as $section)--}}
    {{--                @include('frontend.partials.sections', ['sections' => $section])--}}
    {{--            @endforeach--}}
    {{--        </ul>--}}
    {{--    @endif--}}
@endsection
