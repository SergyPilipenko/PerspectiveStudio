@extends('admin')
@section('content')
    <div class="card">
        <form action="{{ route('admin.catalog.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            {{ method_field('put') }}
            @csrf
        <div class="card-body v-cloak--hidden">
        <div class="category-control">
            <div class="row card-control-header">
                <div class="col-md-10">
                    <div class="product-category-header">
                        <div class="product-category-title">
                            <h3>Редактирование категории</h3>
                        </div>
                        <div class="product-category-language">
                            <b-dropdown id="dropdown-1" text="Локализация: {{ $category->locale->getLocale() }}" variant="outline-default" class="m-md-2">
                                <b-dropdown-item :href="'{{ route('switch-locale', 'ru') }}'">ru</b-dropdown-item>
                                <b-dropdown-item :href="'{{ route('switch-locale', 'ua') }}'">ua</b-dropdown-item>
                                <b-dropdown-item :href="'{{ route('switch-locale', 'en') }}'">en</b-dropdown-item>
                            </b-dropdown>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success float-right">Сохранить</button>
                    <confirm
                        :action="'{{ route('admin.catalog.categories.destroy', $category->id) }}'"
                        :header="'Вы уверены что хотите удалить категорию?'"
                        :body="'(Все дочерние категории будут тоже удалены)'"
                    ></confirm>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="offset-md-10 col-md-2">

                                </div>
                            </div>
                            <div class="product-category-body">
                                <div class="row">
                                    @include('admin.catalog.categories.sidebar')
                                    <div class="col-md-10">
                                        <accordian>
                                            <div slot="header">Общее</div>
                                            <div slot="body">
                                                <div class="category-active">
                                                    <div class="form-check">
                                                        Показывать в меню
                                                        <label class="switch">
                                                            <input type="checkbox" {{ $category->activity > 0 ? 'checked' : '' }} name="category_activity">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="category-type">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="type" id="type">Тип: [{{ $category->locale->getLocale() }}]</label>
                                                                <select name="type" id="type" class="form-control" disabled>
                                                                    @foreach($category->categoryTypes as $type)
                                                                        <option value="type" {{ $category->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="category-title">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="category_title">Название: [{{ $category->locale->getLocale() }}]</label>
                                                                <input type="text" class="form-control" name="{{ $category->locale->locatedInputName('category_title') }}" value="{{ old('category_title') ?? $category->category_title }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sort">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="sort">Сортировка:</label>
                                                                <input type="number" name="position" class="form-control" value="{{ old('position') ?? $category->position }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="description">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="description">Описание:</label>
                                                                <partfix-ckeditor :name="'{{ $category->locale->locatedInputName('description') }}'" :content="{{ json_encode($category->description) }}"></partfix-ckeditor>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </accordian>
                                        <accordian>
                                            <div slot="header">Изображение</div>
                                            <div slot="body">
                                                <div class="image">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <category-image-upload  :category_image="'{{ $category->image }}'"></category-image-upload>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </accordian>
                                        <accordian>
                                            <div slot="header">Seo</div>
                                            <div slot="body">
                                                <div class="slug">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="{{ $category->locale->locatedInputName('slug') }}">URL: [{{ $category->locale->getLocale() }}]</label>
                                                                <input type="text"  class="form-control" name="{{ $category->locale->locatedInputName('slug') }}" value="{{ $category->slug ?: '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="{{ $category->locale->locatedInputName('meta_title') }}">Meta title: [{{ $category->locale->getLocale() }}]</label>
                                                            <textarea class="form-control" id="{{ $category->locale->locatedInputName('meta_title') }}" name="{{ $category->locale->locatedInputName('meta_title') }}" rows="4">{{ $category->meta_title }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="{{ $category->locale->locatedInputName('meta_description') }}">Meta description: [{{ $category->locale->getLocale() }}]</label>
                                                            <textarea class="form-control" id="{{ $category->locale->locatedInputName('meta_description') }}" name="{{ $category->locale->locatedInputName('meta_description') }}" rows="4">{{ $category->meta_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="{{ $category->locale->locatedInputName('meta_keywords') }}">Meta keywords: [{{ $category->locale->getLocale() }}]</label>
                                                            <textarea class="form-control" id="{{ $category->locale->locatedInputName('meta_keywords') }}" name="{{ $category->locale->locatedInputName('meta_keywords') }}" rows="4">{{ $category->meta_keywords }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </accordian>
                                        <accordian>
                                            <div slot="header">Аттрибуты фильтра</div>
                                            <div slot="body">
                                                <div class="form-group">
                                                    <div class="filterable-attributes">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-flat form-check-primary">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" name="applyToChildren" class="form-check-input">
                                                                            Применить ко всем вложеным категориям
                                                                            <i class="input-helper"></i>
                                                                        </label>
                                                                    </div>
                                                                    <select size="15" multiple name="filterableAttributes[]" class="form-control" id="filterable-attributes">
                                                                        @foreach ($filterableAttributes as $attribute)
                                                                            <option {{ $category->filterableAttributes->contains('id', $attribute->id) ? 'selected' : ''  }} value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </accordian>
                                        @if($category->type == 'tecdoc')
                                            <accordian>
                                                <div slot="header">Соотношение с tecdoc категориями</div>
                                                <div slot="body">
                                                    <tecdoc-categories-tree
                                                        :categories="{{ $tec_doc_categories }}"
                                                        :category_distinct_tecdoc_categories="{{ $category_distinct_tecdoc_categories }}"
                                                        :disabled_distinct_tecdoc_categories="{{ $disabled_distinct_tecdoc_categories }}"
                                                    ></tecdoc-categories-tree>
                                                </div>
                                            </accordian>
                                        @endif
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
