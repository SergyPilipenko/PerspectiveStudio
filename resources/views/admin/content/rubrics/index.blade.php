@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <h3>Рубрики</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.content.rubrics.create') }}" class="btn btn-primary float-right">Добавить</a>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Заголовок</th>
                            <th>Url</th>
                            <th>Описание</th>
                            <th>Управление</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rubrics as $rubric)
                            <tr>
                                <td>{{ $rubric->id }}</td>
                                <td>{{ $rubric->title }}</td>
                                <td>{{ $rubric->slug }}</td>
                                <td>{{ $rubric->description }}</td>
                                <td>
                                    <div class="control-container">
                                        <a href="{{ route('admin.content.rubrics.edit', $rubric->id) }}">
                                            <i class="ti-pencil-alt"></i>
                                            Редактировать
                                        </a>
                                        <form action="{{ route('admin.content.rubrics.destroy', $rubric->id) }}" method="POST">
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
        </div>
    </div>
@endsection
