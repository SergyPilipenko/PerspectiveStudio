@extends('admin')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">Диагностика</h4>
                </div>
            </div>
        </div>
    </div>
    @if($errors->count())
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-danger">Ошибок: {{ $errors->total() }}</h1>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Артикул</th>
                                <th>
                                    Производитель
                                </th>
                                <th>
                                    Количество
                                </th>
                                <th>
                                    Цена
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($errors as $error)
                                <tr>
                                    <td>
                                        {{ $error->article }}
                                        @if($error->errors->contains('error', 'article_not_found'))
                                            <div class="text-danger">
                                                Артикул не найден
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $error->supplier }}
                                        @if($error->errors->contains('error', 'supplier_not_found'))
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="text-danger">
                                                        Производитель не найден
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $error->price }}
                                    </td>
                                    <td>
                                        {{ $error->available }}
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="offset-md-4 col-md-4">
                                <a href="{{ route('admin.catalog.errors', $import_setting) }}" class="btn btn-primary">Показать все и исправить</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($prices_count)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="text-success grid-margin">
                            {{ $prices_count }} успешно обновлено
                        </div>
                        <a href="{{ route('admin.catalog.prices', $import_setting) }}" class="btn-success btn ">Показать все</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection