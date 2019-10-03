@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <h3>Локализации</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.settings.locales.create') }}" class="btn btn-primary float-right">Добавить</a>
                </div>
            </div>
            @if($locales->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Код</th>
                        <th>Название</th>
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($locales as $locale)
                        <tr>
                            <td>{{ $locale->code }}</td>
                            <td>{{ $locale->name }}</td>
                            <td>
                                <div class="control-container">
                                    <a href="{{ route('admin.settings.locales.edit', $locale->id) }}">
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
        {{ $locales->links() }}
    </div>
@endsection
