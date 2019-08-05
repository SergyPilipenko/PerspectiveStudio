@extends('frontend')
@section('content')
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('frontend.categories.index', $category) }}">{{ $category->title }}</a>
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
