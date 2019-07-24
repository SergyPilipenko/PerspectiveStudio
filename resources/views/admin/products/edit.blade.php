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
                    <div>
                        <b-tabs content-class="mt-3" fill>
                            <b-tab title="Основное" active>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Название</label>
                                        <input type="text" class="form-control" value="{{ $price->articleNumber->article->NormalizedDescription }}" name="NormalizedDescription">
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="">Оригинальный номер</label>
                                        </div>
                                        <div class="d-flex  justify-content-between align-items-center">
                                            <div>
                                                <input type="text" class="form-control" value="{{ $price->articleNumber->datasupplierarticlenumber }}" name="datasupplierarticlenumber">
                                            </div>
                                            <div>
                                               <art-cross></art-cross>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </b-tab>
                            <b-tab title="Фото/видео/файлы"><p>I'm the second tab</p></b-tab>
                            <b-tab title="Цены"><p>I'm the tab with the very, very long title</p></b-tab>
                            <b-tab title="Каталог"><p>I'm the tab with the very, very long title</p></b-tab>
                            <b-tab title="Seo"><p>I'm the tab with the very, very long title</p></b-tab>
                            <b-tab title="Характеристики"><p>I'm the tab with the very, very long title</p></b-tab>
                        </b-tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection