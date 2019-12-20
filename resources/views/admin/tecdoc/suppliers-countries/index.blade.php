@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <h3>Локализации</h3>
                </div>
                <div class="col-md-2">
                    <a href="" class="btn btn-primary float-right">Добавить</a>
                </div>
            </div>
            @if($suppliers->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Код</th>
                            <th>Название</th>
                            <th>Страна</th>
                            <th>Управление</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->matchcode }}</td>
                                <td>{{ $supplier->description }}</td>
                                <td>{{ $supplier->country }}</td>
                                <td>
                                    <div class="control-container">
                                        <a href="">
                                            <i class="ti-pencil-alt"></i>
                                            Редактировать
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                Список пуст...
            @endif
        </div>
        {{ $suppliers->links() }}
    </div>
@endsection
