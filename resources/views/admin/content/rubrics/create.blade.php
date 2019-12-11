@extends('admin')
@section('content')
    <div class="card">

        <form action="{{ route('admin.content.rubrics.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Новая рубрика</h3>
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
                                    <div class="form-group required">
                                        <label for="position">Сортировка:</label>
                                        <input type="number" id="position"
                                               name="position"
                                               value="{{ old('position') ?? '10' }}"
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
                                               value="{{ old('title') ?? '' }}"
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
                                               value="{{ old('slug') ?? '' }}"
                                               required
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="descritpion">Описание:</label>
                                        <textarea class="form-control" id="descritpion" name="description" rows="3"></textarea>
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
