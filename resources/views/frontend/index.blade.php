@extends('frontend')
@section('content')
    <select-car :auto_brands="{{ json_encode($brands) }}"></select-car>
@endsection
