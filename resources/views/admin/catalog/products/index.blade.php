@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <h3>Товары</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.catalog.products.create') }}" class="btn btn-primary float-right">Добавить</a>
                </div>
            </div>
            @if($products->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Артикул</th>
                        <th>Код</th>
                        <th>Тип</th>
                        <th>Набор аттрибутов</th>
                        <th>Прайс</th>
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->article }}</td>
                                <td>{{ $product->getAttrValue('name') }}</td>
                                <td>{{ $product->type }}</td>
                                <td>{{ $product->attribute_family->name }}</td>

                                <td>{{ $product->getAttrValue('price') ?? '0.00' }}</td>
                                <td>
                                    <div class="control-container">
                                        <a href="{{ route('admin.catalog.products.edit', $product) }}">
                                            <i class="ti-pencil-alt"></i>
                                            Редактировать
                                        </a>
                                        <form action="{{ route('admin.catalog.products.destroy', $product) }}" method="POST">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <button><i class="ti-trash"></i> Удалить</button>
                                        </form>
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
        {{ $products->links() }}
    </div>
@endsection
