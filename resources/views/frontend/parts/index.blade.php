@extends('frontend')
@section('content')
    @if(count($sections) > 0)
        <ul>
            @foreach($sections as $section)
                @include('frontend.partials.sections', ['sections' => $section])
            @endforeach
        </ul>
    @endif
@endsection
