
@extends('admin')
@section('content')
    {{ var_dump($errors->all()) }}

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
        <form action="{{ !$category ? route('admin.categories.store') : route('admin.categories.store-subcategory', $category->id) }}" method="POST">
            @csrf
            <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="offset-md-10 col-md-2">
                                <button class="btn btn-success float-right">Сохранить</button>
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
                                                <input type="text" class="form-control" name="category_title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="category-slug">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="category_title">URL</label>
                                                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}">
                                            </div>
                                        </div>
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
