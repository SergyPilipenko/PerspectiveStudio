@extends('admin')
@section('content')
    <div class="category-control">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">{{ $category->category_title }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.catalog.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
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
                                        :action="'{{ route('admin.catalog.categories.destroy', $category->id) }}'"
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
                                            Включить категорию
                                            <label class="switch">
                                                <input type="checkbox" {{ $category->activity > 0 ? 'checked' : '' }} name="category_activity">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="sort">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sort">Сортировка:</label>
                                                    <input type="number" name="position" class="form-control" value="{{ old('position') ?? $category->position }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="category-title">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="category_title">Название</label>
                                                    <input type="text" class="form-control" name="category_title" value="{{ old('category_title') ?? $category->category_title }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="slug">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="url">URL:</label>
                                                    <input type="text"  class="form-control" name="slug" value="{{ $category->slug ?: '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="image">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
{{--                                                    <category-image--}}
{{--                                                        :current_image="'{{ $category->image }}'"--}}
{{--                                                        :category_id="'{{ $category->id }}'"--}}
{{--                                                        :action="'{{ route('admin.tecdoc.categories.image', $category->id) }}'"--}}
{{--                                                    ></category-image>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
{{--                                            <tecdoc-categories-tree--}}
{{--                                                :categories="{{ $tec_doc_categories }}"--}}
{{--                                                :category_distinct_tecdoc_categories="{{ $category_distinct_tecdoc_categories }}"--}}
{{--                                                :disabled_distinct_tecdoc_categories="{{ $disabled_distinct_tecdoc_categories }}"--}}
{{--                                            ></tecdoc-categories-tree>--}}
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
