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
                                        <td>{{ $price->articleNumber->datasupplierarticlenumber }}</td>
                                        <td>{{ $price->articleNumber->article->NormalizedDescription }}</td>
                                        <td>{{ $price->articleNumber->supplier->description }}</td>
                                        <td>{{ $price->price }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $price) }}"><i class="ti-pencil-alt"></i>
                                                Редактировать
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection