@extends('frontend')
@section('content')
    <section class="category">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumbs">
                        <li><a href="#">Главная</a></li>
                        <li><a href="#">Легковые</a></li>
                        <li><a href="#">Запчасти для Volkswagen Transporter</a></li>
                    </ul>
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
