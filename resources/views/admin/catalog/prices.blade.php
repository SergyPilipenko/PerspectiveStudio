@extends('admin')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">Товары</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Артикул</th>
                            <th>Название</th>
                            <th>Производитель</th>
                            <th>Количество</th>
                            <th>Цена</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prices as $price)
                            <tr>
                                <td>
                                    {{ $price->articleNumber->datasupplierarticlenumber }}
                                </td>
                                <td>{{ $price->articleNumber->article->NormalizedDescription }}</td>
                                <td>{{ $price->articleNumber->supplier->description }}</td>
                                <td>{{ $price->available }}</td>
                                <td>{{ $price->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection