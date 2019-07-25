@extends('admin')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">Изменить товар</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="grid-margin">
                        <b-tabs content-class="mt-3" fill>
                            <b-tab title="Основное" >
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Название</label>
                                        <input type="text" class="form-control" value="{{ $article->article->NormalizedDescription }}" name="NormalizedDescription">
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="">Оригинальный номер</label>
                                        </div>
                                        <div class="d-flex  justify-content-between align-items-center">
                                            <div>
                                                <input type="text" class="form-control" value="{{ $article->datasupplierarticlenumber }}" name="datasupplierarticlenumber">
                                            </div>
                                            <div>
                                               <art-cross :crosses="{{ json_encode($article->crosses)  }}"></art-cross>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="supplier">Бренд</label>
                                        <select class="form-control" name="supplier">
                                            @foreach($suppliers as $supplier)
                                                <option {{ $article->supplierid == $supplier->id ? 'selected' : '' }}>{{ $supplier->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lable">Лейбл</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">Выбрать</option>
                                            <option value="">Хит</option>
                                            <option value="">Новинка</option>
                                            <option value="">Скидка</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lable">% бонуса</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lable">Валюта</label>
                                                <select name="" id="" class="form-control">
                                                    <option value="">UAH</option>
                                                    <option value="">USD</option>
                                                    <option value="">EUR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Описание</label>
                                        <textarea class="form-control" id="description" rows="3"></textarea>
                                    </div>
                                </div>
                            </b-tab>
                            <b-tab title="Фото/видео/файлы"><p>I'm the second tab</p></b-tab>
                            @if($article->prices->count())
                                <b-tab title="Цены">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>
                                                Поставщик
                                            </th>
                                            <th>
                                                Цена, UAH
                                            </th>
                                            <th>
                                                Наличие
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($article->prices as $price)
                                            <tr>
                                                <td>{{ $price->importSetting->title }}</td>
                                                <td>{{ $price->price }}</td>
                                                <td>{{ $price->available }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </b-tab>
                            @endif
                            <b-tab active title="Каталог">
                                <brands-tree
                                        :brands="{{ json_encode($brands) }}"
                                        :get_models="'{{ route('api.tecdoc.get-models') }}'"
                                        :get_modifications="'{{ route('api.tecdoc.get-modifications') }}'"
                                ></brands-tree>
                            </b-tab>
                            <b-tab title="Seo">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="meta_title">Meta title</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Meta description</label>
                                        <input type="text" class="form-control" name="meta_description">
                                    </div>
                                    <div class="from-group">
                                        <label for="url">URL</label>
                                        <input type="text" class="form-control" name="url">
                                    </div>
                                </div>
                            </b-tab>
                            <b-tab title="Характеристики">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group d-flex justify-content-between align-items-center article_features_tab">
                                            <input type="text" class="form-control">
                                            <button class="btn btn-primary">Добавить</button>
                                        </div>
                                        <h6>Установленные</h6>
                                        <div>
                                            <table class="table table-striped">
                                                <tbody>
                                                    @foreach($article->attributes as $attribute)
                                                        <tr>
                                                            <td>{{ $attribute->displaytitle }}</td>
                                                            <td>{{ $attribute->displayvalue }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </div>
                    <div>
                        <button class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection