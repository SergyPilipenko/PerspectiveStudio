@extends('admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.catalog.attributes.store') }}" method="POST">
                @csrf
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Новый аттрибут</h3>
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

                                    <div class="form-group required">
                                        <label for="code">Код аттрибута</label>
                                        <input type="text" id="code"
                                               name="code"
                                               value="{{ old('code') ?? '' }}"
                                               class="form-control {{ ValidationHelper::errorExists($errors, 'code') ? 'error' : '' }}">
                                        @include('admin.partials.input-errors', ['input_name' => 'code'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="type">Тип</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="text">Text</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="price">Price</option>
                                            <option value="boolean">Boolean</option>
                                            <option value="select">Select</option>
                                            <option value="multiselect">Multiselect</option>
                                            <option value="datetime">Datetime</option>
                                            <option value="date">Date</option>
                                            <option value="image">Image</option>
                                            <option value="file">File</option>
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
                                               value="{{ old('title') ?? '' }}"
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
                                            <option value="1">Да</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_unique">Уникальный</label>
                                        <select name="is_unique" id="is_unique" class="form-control">
                                            <option value="0">Нет</option>
                                            <option value="1">Да</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation">Правила валидации</label>
                                        <select name="validation" id="validation" class="form-control">
                                            <option>Нет</option>
                                            <option value="numeric">Число</option>
                                            <option value="email">Email</option>
                                            <option value="decimal">Число с точкой</option>
                                            <option value="url">URL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                    <accordian>
                        <div slot="header">Конфигурация</div>
                        <div slot="body">
                            <div class="form-group">
                                <label for="is_filterable">Использовать в фильтре</label>
                                <select name="is_filterable" id="is_filterable" class="form-control">
                                    <option value="0">Нет</option>
                                    <option value="1">Да</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_visible_on_front">Отображать в карточке товара</label>
                                <select name="is_visible_on_front" id="is_visible_on_front" class="form-control">
                                    <option value="0">Нет</option>
                                    <option value="1">Да</option>
                                </select>
                            </div>
                        </div>
                    </accordian>
                </div>
            </form>
        </div>
    </div>
@endsection
