@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.catalog.attributes.update', $attribute) }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Изменить атрибут</h3>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success float-right">Сохранить</button>
                    </div>
                </div>
                <div class="v-cloak--hidden">
                    <accordian>
                        <div slot="header">Общее</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="code">Код атрибута</label>
                                        <input type="text" id="code"
                                               name="code"
                                               value="{{ $attribute->code }}"
                                               class="form-control"
                                               disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type">Тип</label>
                                        <select name="type" id="type" class="form-control" disabled="disabled">
                                            @foreach($attribute->inputs['type'] as $value => $option)
                                                <option value="{{ $value }}" {{ $attribute->type == $value ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                    <accordian>
                        <div slot="header">Название</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="title">Название</label>
                                        <input type="text"
                                               name="title"
                                               value="{{ old('title') ?? $attribute->title }}"
                                               id="title" class="form-control {{ ValidationHelper::errorExists($errors, 'title') ? 'error' : '' }}">
                                        @include('admin.partials.input-errors', ['input_name' => 'title'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                    <accordian>
                        <div slot="header">Валидация</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_required">Обязательный</label>
                                        <select name="is_required" id="is_required" class="form-control">
                                            <option value="0">Нет</option>
                                            <option value="1" {{ $attribute->is_required ? 'selected' : '' }}>Да</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_unique">Уникальный</label>
                                        <select name="is_unique" id="is_unique" class="form-control" disabled="disabled">
                                            <option value="0">Нет</option>
                                            <option value="1" {{ $attribute->is_unique ? 'selected' : '' }}>Да</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation">Правила валидации</label>
                                        <select name="validation" id="validation" class="form-control">
                                            <option>Нет</option>
                                            @foreach($attribute->inputs['validation'] as $value => $option)
                                                <option value="{{ $value }}" {{ $attribute->validation == $value ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                    <accordian>
                        <div slot="header">Конфигурация</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_filterable">Использовать в фильтре</label>
                                        <select name="is_filterable" id="is_filterable" class="form-control">
                                            <option value="0">Нет</option>
                                            <option value="1" {{ $attribute->is_filterable ? 'selected' : '' }}>Да</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_visible_on_front">Отображать в карточке товара</label>
                                        <select name="is_visible_on_front" id="is_visible_on_front" class="form-control">
                                            <option value="0">Нет</option>
                                            <option value="1" {{ $attribute->is_visible_on_front ? 'selected' : '' }}>Да</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                </div>
            </form>
        </div>
    </div>
@endsection
