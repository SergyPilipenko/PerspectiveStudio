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
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label for="position">Сортировка:</label>
                                        <input type="number" id="position"
                                               name="position"
                                               value="{{ old('position') ?? $rubric->position }}"
                                               step="10"
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="descritpion">Описание:</label>
                                        <textarea class="form-control" id="descritpion" name="description" rows="3">{{ old('description') ?? $rubric->description }}</textarea>
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
                                            <accordian>
                                                <div slot="header">{{ $group->title }}</div>
                                                <div slot="body">
                                                    @if($categories->count())
                                                        @foreach($categories as $category)
                                                            <div class="form-check form-check-flat form-check-primary">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input" name="categories[{{ $group->id }}][]">
                                                                    {{ $category->category_title }}
                                                                    <i class="input-helper"></i></label>
                                                            </div>
                                                        @endforeach
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
