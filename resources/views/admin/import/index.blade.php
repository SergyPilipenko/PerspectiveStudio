@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-6 grid-margin">
            <div class="hidden-print with-border">
                <a href="{{ route('admin.import.create') }}" data-style="zoom-in" class="btn btn-primary ladda-button">
                    <span class="ladda-label"><i class="fa fa-plus"></i> Добавить схему импорта</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Название
                                </th>
                                <th>
                                    Загрузка
                                </th>
                                <th>
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($import_settings as $import_setting)
                                <tr role="row" class="odd">
                                    <td tabindex="0">
                                        <span>
                                            {{ $import_setting->title }}
                                        </span>
                                    </td>
                                    <td>
                                        <import-price
                                                :type="/{{ $import_setting }}/"
                                                :action="'{{ route('admin.import.price', $import_setting->id) }}'"
                                                :routes="'{{ $routes }}'"
                                        ></import-price>
                                    </td>
                                    <td>
                                        <div class="control-container">
                                            <a href="{{ route('admin.import.edit', $import_setting) }}"  class="">
                                                <i class="ti-pencil-alt"></i>
                                                Редактировать
                                            </a>
{{--                                            <a  class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Редактировать</a>--}}
                                            <form action="{{ route('admin.import.destroy', $import_setting) }}" method="POST">
                                                {{ method_field('delete') }}
                                                @csrf
                                                <button><i class="ti-trash"></i> Удалить</button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection