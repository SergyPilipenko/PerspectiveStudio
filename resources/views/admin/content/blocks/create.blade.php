@extends('admin')
@section('content')
    <div class="card">

        <form action="{{ route('admin.content.blocks.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Новый блок</h3>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success float-right">Создать</button>
                    </div>
                </div>
                <div class="v-cloak--hidden">
                    <accordian>
                        <div slot="header">Общее</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span>Включить блок</span>
                                                    <label class="switch">
                                                        <input type="checkbox" checked name="enabled">
                                                        <span class="slider round"></span>
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="title">Заголовок</label>
                                        <input type="text" id="title"
                                               name="title"
                                               value="{{ old('title') ?? '' }}"
                                               required
                                               class="form-control">
                                    </div>
                                    <div class="form-group required">
                                        <label for="identifier">Идентификатор</label>
                                        <input type="text" id="identifier"
                                               name="identifier"
                                               value="{{ old('identifier') ?? '' }}"
                                               required
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editorContent">Конент</label>
                                        <partfix-ckeditor content="{{ old('editorContent') ? json_encode(old('editorContent')) : '' }}"></partfix-ckeditor>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@endsection
