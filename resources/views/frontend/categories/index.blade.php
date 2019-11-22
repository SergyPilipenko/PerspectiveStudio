@section('meta_title', __('meta-tags::meta.frontend-model.title'))
@section('meta_description', __('meta-tags::meta.frontend-model.description'))
@section('meta_keywords', __('meta-tags::meta.frontend-model.keywords'))
@extends('frontend')
@section('content')
    <section class="category">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! Breadcrumbs::render('frontend.model', $brand, $model) !!}
                    <div>
                        <h2 class="category__title">Выберите модификацию для Volkswagen Transporter</h2>
                    </div>
                    <div>
                        <select-car-body
                            :models="{{ $models }}"
                            :year="'{{ Session::get('car-year') }}'"
                            :actions="'{{ json_encode($routes) }}'"
                        ></select-car-body>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">

    </div>
@endsection
