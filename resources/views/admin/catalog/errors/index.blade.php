@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if($setting->importErrors->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                @foreach($columns as $column)
                                    <th>{{ $column->title }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($setting->importErrors as $error)
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
                                                        <div>
                                                            <form action="{{ route('admin.catalog.errors.add-mapping', $setting->id) }}" method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{ $error->supplier }}" name="supplier">
                                                                <select class="form-control" name="mapping">
                                                                    <option value="">Не выбрано</option>
                                                                    @foreach($suppliers as $supplier)
                                                                        <option value="{{ $supplier->id }}">{{ $supplier->description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="submit" value="Применить" class="btn btn-success">
                                                            </form>
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
                    </div>
                    @else
                        Ошибок загрузки нет
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection