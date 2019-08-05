@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-6 grid-margin">
            {{ request()->route('cawer') }}
            <div class="hidden-print with-border">
                <a href="{{ route('admin.categories.create') }}" data-style="zoom-in" class="btn btn-primary ladda-button">
                    <span class="ladda-label"><i class="fa fa-plus"></i>Создать</span>
                </a>
            </div>
        </div>
    </div>
@endsection
