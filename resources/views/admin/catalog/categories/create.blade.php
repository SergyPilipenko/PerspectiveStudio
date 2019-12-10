@extends('admin')
@section('content')
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
        <form action="{{ $store }}" method="POST">
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span>
                                                        Показывать в меню
                                                    </span>
                                                    <label class="switch">
                                                        <input type="checkbox" name="category_activity">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <slugify-title
                                        :old="'{{ json_encode(old()) }}'"
                                        :errors_list="'{{ json_encode($errors->messages()) }}'"
                                        :locale="'{{ config('app.fallback_locale') }}'"
                                        :types="{{ $categoryTypes }}"
                                        :parent_category="{{ $parentCategory ? json_encode($parentCategory) : 0}}"
                                    ></slugify-title>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
