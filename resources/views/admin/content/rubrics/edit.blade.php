@extends('admin')
@section('content')
    <div class="card">
        <form action="{{ route('admin.content.rubrics.update', $rubric->id) }}" method="POST">
            {{ method_field('PUT') }}
            @csrf
            <div class="card-body">
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Изменить рубрику</h3>
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
                                <div class="form-check">
                                    <div class="col-md-12">
                                                <span>
                                                    Показывать в меню
                                                </span>
                                        <label class="switch">
                                            <input type="checkbox" {{ old('show_in_menu') || $rubric->show_in_menu ? 'checked' : '' }} name="show_in_menu">
                                            <span class="slider round"></span>
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="position">Сортировка:</label>
                                        <input type="number" id="position"
                                               name="position"
                                               value="{{ old('position') ?? $rubric->position }}"
                                               min="0"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="title">Заголовок</label>
                                        <input type="text" id="title"
                                               name="title"
                                               value="{{ old('title') ?? $rubric->title }}"
                                               required
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="slug">URL:</label>
                                        <input type="text" id="slug"
                                               name="slug"
                                               value="{{ old('slug') ?? $rubric->slug }}"
                                               required
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descritpion">Описание:</label>
                                        <partfix-ckeditor :name="'description'" :content="{{ json_encode($rubric->description) }}"></partfix-ckeditor>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordian>
                    <accordian>
                        <div slot="header">Группы</div>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-3 md-offset-9 mb-4">
                                    <a href="{{ route('admin.content.rubrics.groups.create', $rubric->id) }}" class="btn btn-primary">Добавить</a>
                                </div>
                            </div>
                            @if($rubric->groups->count())
                                @foreach($rubric->groups as $group)
                                    <div class="row">
                                        <div class="col-md-11">
                                            <accordian :default="false">
                                                <div slot="header">{{ $group->title }}</div>
                                                <div slot="body">
                                                    @if($categories->count())

                                                        <ul>
                                                            @foreach($categories as $category)
                                                                @include('admin.content.rubrics.groups.categories', ['category' => $category])
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </accordian>
                                        </div>
                                        <div class="control-container">
                                            <div class="buttons">
                                                <a href="{{ route('admin.content.rubrics.groups.edit', [$rubric->id, $group->id]) }}" class="ti-settings"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@endsection
