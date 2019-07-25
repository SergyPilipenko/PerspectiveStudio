@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-6 grid-margin">
            <div class="hidden-print with-border">
                <a href="{{ route('admin.import.create') }}" data-style="zoom-in" class="btn btn-primary ladda-button">
                    <span class="ladda-label"><i class="fa fa-plus"></i> Добавить</span>
                </a>
            </div>
        </div>
    </div>
    @if($prices->count())
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="search">
                            <form action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Оригинальный номер</label>
                                            <input type="text" class="form-control" name="article" value="{{ request()->article  }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Производитель</label>
                                            <input type="text" class="form-control" name="supplier">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Модель авто</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="" class="empty-label"> </label>
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Поиск">
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Номер
                                </th>
                                <th>
                                    Название
                                </th>
                                <th>
                                    Производитель
                                </th>
                                <th>
                                    Цена
                                </th>
                                <th>
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($prices as $price)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" checked="">
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $price->datasupplierarticlenumber }}</td>
                                        <td>{{ $price->article->NormalizedDescription }}</td>
                                        <td>{{ $price->supplier->description }}</td>
                                        <td>
                                            @if($price->prices->count())
                                                {{ $price->prices->first()->price }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $price) }}"><i class="ti-pencil-alt"></i>
                                                Редактировать
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $prices->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection