@extends('admin')
@section('content')
    <div class="row m-t-20">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <parser
                                :routes="'{{ $routes }}'"
                                :columns="'{{ $columns }}'"
                        ></parser>
                    </div>
                </div>
        </div>
    </div>
@endsection
