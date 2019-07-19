@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Схема загрузки
                                </th>
                                <th>
                                    Дата
                                </th>
                            </tr>
                            </thead>
{{--                            {{ dd($item) }}--}}

                            <tbody>
                                @foreach($history as $item)
                                    <tr role="row" class="odd">
                                        <td tabindex="0">
                                            {{ $item->import_setting->title }}
                                        </td>
                                        <td>
                                            {{ $item->import_setting->created_at }}
                                        </td>
                                        <td>
                                            <div class="control-container">
                                                <a href=""  class="">
                                                    <i class="ti-pencil-alt"></i>
                                                    Редактировать
                                                </a>
                                                <form action="" method="POST">
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