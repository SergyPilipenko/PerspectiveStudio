@extends('admin')
@section('content')
    <a href="{{ route('admin.import.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Вернуться к списку</a>
    <div class="row m-t-20">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <parser
                                :routes="'{{ $routes }}'"
                        ></parser>
                    </div>
                </div>
        </div>
    </div>
@endsection
