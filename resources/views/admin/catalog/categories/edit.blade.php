@extends('admin')
@section('content')
    <div class="category-control">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">{{ $category->title }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
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
                                        :action="'{{ route('admin.categories.destroy', $category->id) }}'"
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
{{--                                            {{ dd($category->activity) }}--}}
                                            <label class="form-check-label">
                                                Включить категорию
                                                <input type="checkbox" {{ $category->activity != 0 ? 'checked' : '' }} class="form-check-input" name="category_activity">
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="sort">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sort">Сортировка:</label>
                                                    <input type="number"  class="form-control" value="{{ $category->position ?: 1 }}">
                                                </div>
                                            </div>
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
                                                    <category-image
                                                        :current_image="'{{ $category->image }}'"
                                                        :category_id="'{{ $category->id }}'"
                                                        :action="'{{ route('admin.categories.image', $category->id) }}'"
                                                    ></category-image>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <tecdoc-categories-tree
                                                :categories="{{ $tec_doc_categories }}"
                                                :category_distinct_tecdoc_categories="{{ $category_distinct_tecdoc_categories }}"
                                                :disabled_distinct_tecdoc_categories="{{ $disabled_distinct_tecdoc_categories }}"
                                            ></tecdoc-categories-tree>
                                        </div>
                                    </div>
                                    <div class="accordion-container">
                                        <accordion-list :header="'Seo'">
                                            <div>
                                                <div class="meta_title">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="meta_title">Meta title:</label>
                                                                <input type="text"  class="form-control" name="meta_title" value="{{ $category->seo ? $category->seo->meta_title : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="meta_description">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="meta_description">Meta description:</label>
                                                                <textarea type="text"  class="form-control" name="meta_description">{{ $category->seo ? $category->seo->meta_description : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="meta_keywords">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="meta_description">Meta keywords:</label>
                                                                <textarea type="text"  class="form-control" name="meta_keywords">{{ $category->seo ? $category->seo->meta_keywords : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </accordion-list>
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
