@extends('admin')
@section('content')
    <div class="card">
        <form action="{{ route('admin.catalog.products.store') }}">
            <div class="card-body">
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Новый товар</h3>
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
                                        <label for="type">Тип</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="simple">Обычный</option>
                                        </select>
                                    </div>
                                    <div class="form-group required">
                                        <label for="attribute_family">Набор атрибутов</label>
                                        <select name="attribute_family" id="attribute_family" class="form-control">
                                            @foreach($attributes_families as $attribute_family)
                                                <option value="{{ $attribute_family->id }}">{{ $attribute_family->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group required">
                                        <label for="article">Артикул</label>
                                        <input type="text" id="article"
                                               name="article"
                                               value="{{ old('article') ?? '' }}"
                                               class="form-control {{ ValidationHelper::errorExists($errors, 'article') ? 'error' : '' }}">
                                        @include('admin.partials.input-errors', ['input_name' => 'article'])
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
