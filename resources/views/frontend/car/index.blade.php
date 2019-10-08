@extends('frontend')
@section('content')
    <section class="category">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="breadcrumbs">
                        <li><a href="#">Главная</a></li>
                        <li><a href="#">Легковые</a></li>
                        <li><a href="#">Запчасти для Volkswagen Transporter</a></li>
                    </ul>
                    <div class="white-bg">
                        <h2 class="category__title">Каталог запчастей на <span>{{ $car->brand->description }} {{ $car->model->description }} {{ $car->year }}</span></h2>
                        @foreach($categories as $category)
                            @if($category->children->count())
                                <div class="category__block">
                                    <h3 class="category__block-title">
                                        <span>{{ $category->title }}</span>
                                    </h3>
                                    <span class="category__block-subtitle">
                                    {{ $car->brand->description }} {{ $car->model->description }}
                                </span>
                                    <div class="category__block-items">
                                        @foreach($category->children as $child)
                                            <a href="{{ route('frontend.category', [$brand, $model, $modification, $child->slug]) }}" class="category__block-item"><img src="{{ file_exists($child->image) ? asset($child->image) : asset('img/frontend/img/images-empty.png') }}" alt="list"><span>{{ $child->title }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
{{--                        <div class="category__block">--}}
{{--                            <h3 class="category__block-title">--}}
{{--                                <span style="min-width: 278px;">Тормозная система</span>--}}
{{--                            </h3>--}}
{{--                            <span class="category__block-subtitle">--}}
{{--								Volkswagen Transporter--}}
{{--							</span>--}}
{{--                            <div class="category__block-items">--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list1.png" alt="list"><span>Тормозные--}}
{{--										колодки</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list2.png" alt="list"><span>Фильтры</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list3.png" alt="list"><span>Масла</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list4.png" alt="list"><span>Освещение</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list5.png" alt="list"><span>Свечи--}}
{{--										зажигания</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list6.png"--}}
{{--                                                                              alt="list"><span>Аммортизаторы</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list1.png" alt="list"><span>Тормозные--}}
{{--										колодки</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list2.png" alt="list"><span>Фильтры</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list3.png" alt="list"><span>Масла</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list4.png" alt="list"><span>Освещение</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list5.png" alt="list"><span>Свечи--}}
{{--										зажигания</span></a>--}}
{{--                                <a href="#" class="category__block-item"><img src="/img/frontend/img/list6.png"--}}
{{--                                                                              alt="list"><span>Аммортизаторы</span></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="category__block">
                            <h3 class="category__block-title">
                                <span>Шины и диски</span>
                            </h3>
                            <span class="category__block-subtitle">
								Volkswagen Transporter
							</span>
                            <div class="d-flex flex-column flex-lg-row">
                                <div class="category__block-half flex-column flex-sm-row">
                                    <div class="d-flex flex-column mr70">
                                        <div class="d-flex flex-column">
                                            <h3>Сезон шины</h3>
                                            <ul class="d-flex align-items-center">
                                                <li class="season">
                                                    <a href="#" class="d-flex align-items-center">
                                                        <img src="/img/frontend/img/sun.png" alt="sun">
                                                        Летние
                                                    </a>
                                                </li>
                                                <li class="season">
                                                    <a href="#" class="d-flex align-items-center">
                                                        <img src="/img/frontend/img/snow.png" alt="snow">
                                                        Зимние
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h3>Размеры шин</h3>
                                            <ul>
                                                <li>
                                                    <a href="#">R16 205/55</a>
                                                </li>
                                                <li>
                                                    <a href="#">R17 205/55</a>
                                                </li>
                                                <li>
                                                    <a href="#">R17 205/60</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mr70">
                                        <h3>Производители шин</h3>
                                        <div class="d-flex">
                                            <ul class="mr50">
                                                <li>
                                                    <a href="#">Barum</a>
                                                </li>
                                                <li>
                                                    <a href="#">BFGoodrich</a>
                                                </li>
                                                <li>
                                                    <a href="#">Continental</a>
                                                </li>
                                                <li>
                                                    <a href="#">Cordiant</a>
                                                </li>
                                                <li>
                                                    <a href="#">Debica</a>
                                                </li>
                                                <li>
                                                    <a href="#">Dunlop</a>
                                                </li>
                                                <li>
                                                    <a href="#">Fulda</a>
                                                </li>
                                                <li>
                                                    <a href="#">Uniroyal</a>
                                                </li>
                                                <li>
                                                    <a href="#">Maxxis</a>
                                                </li>
                                                <li>
                                                    <a href="#">Gislaved</a>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="#">Barum</a>
                                                </li>
                                                <li>
                                                    <a href="#">BFGoodrich</a>
                                                </li>
                                                <li>
                                                    <a href="#">Continental</a>
                                                </li>
                                                <li>
                                                    <a href="#">Cordiant</a>
                                                </li>
                                                <li>
                                                    <a href="#">Debica</a>
                                                </li>
                                                <li>
                                                    <a href="#">Dunlop</a>
                                                </li>
                                                <li>
                                                    <a href="#">Fulda</a>
                                                </li>
                                                <li>
                                                    <a href="#">Uniroyal</a>
                                                </li>
                                                <li>
                                                    <a href="#">Maxxis</a>
                                                </li>
                                                <li>
                                                    <a href="#">Gislaved</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="category__block-half flex-column flex-sm-row">
                                    <div class="d-flex flex-column mr70">
                                        <h3>Размеры дисков</h3>
                                        <ul>
                                            <li><a href="#">7.5/R16 ET42</a></li>
                                            <li><a href="#">7/R16 ET46</a></li>
                                            <li><a href="#">7.5/R17 ET45</a></li>
                                            <li><a href="#">8/R18 ET26</a></li>
                                            <li><a href="#">8/R18 ET47</a></li>
                                            <li><a href="#">8/R19 ET39</a></li>
                                        </ul>
                                    </div>
                                    <div class="d-flex flex-column mr70">
                                        <h3>Производители дисков</h3>
                                        <div class="d-flex">
                                            <ul class="mr50">
                                                <li>
                                                    <a href="#">Barum</a>
                                                </li>
                                                <li>
                                                    <a href="#">BFGoodrich</a>
                                                </li>
                                                <li>
                                                    <a href="#">Continental</a>
                                                </li>
                                                <li>
                                                    <a href="#">Cordiant</a>
                                                </li>
                                                <li>
                                                    <a href="#">Debica</a>
                                                </li>
                                                <li>
                                                    <a href="#">Dunlop</a>
                                                </li>
                                                <li>
                                                    <a href="#">Fulda</a>
                                                </li>
                                                <li>
                                                    <a href="#">Uniroyal</a>
                                                </li>
                                                <li>
                                                    <a href="#">Maxxis</a>
                                                </li>
                                                <li>
                                                    <a href="#">Gislaved</a>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="#">Barum</a>
                                                </li>
                                                <li>
                                                    <a href="#">BFGoodrich</a>
                                                </li>
                                                <li>
                                                    <a href="#">Continental</a>
                                                </li>
                                                <li>
                                                    <a href="#">Cordiant</a>
                                                </li>
                                                <li>
                                                    <a href="#">Debica</a>
                                                </li>
                                                <li>
                                                    <a href="#">Dunlop</a>
                                                </li>
                                                <li>
                                                    <a href="#">Fulda</a>
                                                </li>
                                                <li>
                                                    <a href="#">Uniroyal</a>
                                                </li>
                                                <li>
                                                    <a href="#">Maxxis</a>
                                                </li>
                                                <li>
                                                    <a href="#">Gislaved</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="last-goods">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="default-title">
                        последние просмотренные товары
                    </h2>
                    <div class="last-goods__slider">
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good2.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good3.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="awaiting">Под заказ</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good4.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="not-aval">Нет на складе</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good5.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good2.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good3.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="awaiting">Под заказ</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good4.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="not-aval">Нет на складе</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good5.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good1.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good2.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good3.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="awaiting">Под заказ</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good4.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="not-aval">Нет на складе</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                        <div class="last-goods__slide">
                            <a href="#"><img src="/img/frontend/img/last-good5.png" alt="last-good" class="last-goods__image"></a>
                            <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">Hyundai/Kia</span></a><a href="#"><span class="last-goods__type">Фильтр масляный</span></a></div>
                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="last-goods__price">122 грн</span>
                                    <div class="d-flex align-items-center last-goods__available">
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span>В наличии</span>
                                    </div>
                                </div>
                                <button class="last-goods__buy">Купить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="manufacturers">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="manufacturers__description">
                        Проведите профилактическое обслуживание и сделайте своевременный ремонт, увеличьте мощность и улучшите управляемость и торможение для улучшения общей производительности, и придайте вашему автомобилю, грузовику или внедорожнику уникальный внешний вид, при котором головки будут поворачиваться, куда бы вы ни катились. Вы можете сделать все это с помощью запчастей и аксессуаров CARiD. В отличие от некоторых он-лайн продавцов вторичного рынка, у которых есть запасные части, но они не могут помочь вам одеться или продать внешние аксессуары, но у вас нет колес и шин, которые вам нужны, чтобы завершить внешний вид, мы - универсальное направление для всех ваших автомобильных предметов первой необходимости. Неважно, что вы хотите сделать со своим транспортным средством или где вы получаете свои удары - на улице, на трассе или на бездорожье - вы найдете качественные, фирменные запчасти и аксессуары на наших цифровых полках, чтобы превратить ваши автомобильные мечты в реальность.
                    </p>
                    <button class="manufacturers__show-more">
                        Показать больше
                    </button>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.partials._advatages')
{{--    <div class="container">--}}
{{--        <garage--}}
{{--            :garage="{{ $garage }}"--}}
{{--            :current_auto="'{{ json_encode($current_auto) }}'"--}}
{{--        ></garage>--}}
{{--        @if($categories->count())--}}
{{--            <ul>--}}
{{--                @foreach($categories as $category)--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('frontend.category', [$brand, $model, $modification, $category->slug]) }}">{{ $category->title }}</a>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @else--}}
{{--            <h1>Category has not children</h1>--}}
{{--        @endif--}}
{{--        @if(isset($parts) && count($parts))--}}
{{--            <ul>--}}
{{--                @foreach($parts as $part)--}}
{{--                    <li>--}}
{{--                        <a href="">--}}
{{--                            {{ $part->supplier_name }} {{ $part->product_name }} {{ $part->part_number }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @else--}}
{{--            <h1>Parts not found</h1>--}}
{{--        @endif--}}
{{--    </div>--}}
@endsection
