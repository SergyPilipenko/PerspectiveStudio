@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <h3>Блоки</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.content.blocks.create') }}" class="btn btn-primary float-right">Добавить</a>
                </div>
            </div>
            @if($blocks->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Идентификатор</th>
                            <th>Управление</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($blocks as $block)
                            <tr>
                                <td>
                                    {{ $block->title }}
                                </td>
                                <td>
                                    {{ $block->identifier }}
                                </td>
                                <td>
                                    <div class="control-container">
                                        <a href="{{ route('admin.content.blocks.edit', $block->id) }}">
                                            <i class="ti-pencil-alt"></i>
                                            Редактировать
                                        </a>
                                        <form action="{{ route('admin.content.blocks.destroy', $block->id) }}" method="POST">
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
                Ничего не найдено...
            @endif
        </div>
    </div>
@endsection
