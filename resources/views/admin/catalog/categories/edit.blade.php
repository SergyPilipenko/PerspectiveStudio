@extends('admin')
@section('content')
{{--    {{ dd(Session::get('success')) }}--}}
    <div class="category-control">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Новая категория</h4>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            {{ method_field('put') }}
            @csrf
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="offset-md-10 col-md-2">
                                    <button class="btn btn-success float-right">Сохранить</button>
                                    <confirm
                                        :action="'{{ route('admin.categories.destroy', $category) }}'"
                                        :header="'Вы уверены что хотите удалить категорию?'"
                                        :body="'(Все дочерние категории будут тоже удалены)'"
                                    ></confirm>
                                </div>
                            </div>
                            <div class="row">
                                @include('admin.catalog.categories.sidebar')
                                <div class="col-md-10">
                                    <div class="category-active">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                Включить категорию
                                                <input type="checkbox" checked="checked" class="form-check-input" name="category_activity">
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="category-title">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="category_title">Название</label>
                                                    <input type="text" class="form-control" name="category_title" value="{{ old('category_title') ?? $category->title }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <tecdoc-categories-tree :categories="{{ $tec_doc_categories }}"></tecdoc-categories-tree>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
