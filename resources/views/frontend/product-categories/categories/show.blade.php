@section('meta_title', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-product-categories-show.title', $meta_tags))
@section('meta_description', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-product-show.description', $meta_tags))
@section('meta_keywords', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-product-categories-show.keywords', $meta_tags))
@extends('frontend')
@section('content')
    <section class="card">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! Breadcrumbs::render('frontend.product-categories.show', $category) !!}
                </div>
            </div>
        </div>
    </section>
    <div class="subcategory__title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1>{{ $category->alias ? $category->alias : $category->category_title }}</h1>
                        <?php $routes = ['get-brands-by-models-created-year' => route('api.get-brands-by-models-created-year')] ?>
                        <choose-car-button
                            :garage="'{{ json_encode(app('App\Classes\Garage')->getGarage()) }}'"
                            :auto_brands="{{ json_encode(app('App\Classes\Garage')->getCheckedBrands()) }}"
                            :routes="'{{ json_encode($routes) }}'"
                        ></choose-car-button>
{{--                        <choose-car-button :auto_brands="{{ json_encode(app('App\Classes\Garage')->getCheckedBrands()) }}"--}}
{{--                                           :routes="'{{ json_encode($routes) }}'"></choose-car-button>--}}
{{--                            <choose-car-button></choose-car-button>--}}
{{--                        <button>{{ app('App\Classes\Garage')->getGarage()->activeCar ? 'Изменить' : 'Выбрать авто' }}</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subcategory__wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column flex-lg-row">
                        @if(isset($products) && $products->count())
                            <div class="button-wrapper">
                                <button class="subcategory__sidebar-filter d-sm-none">
                                    <img src="{{ asset('img/frontend/img/filter.png') }}" alt="filter">
                                    <span>фильтры</span>
                                </button>
                            </div>
                            @include('partfix\catalog-category-filter::frontend._filter', ['filter' => $category->getFilter(), 'category' => $category])
                            <div class="subcategory__items">
                                <div class="subcategory__header">
                                    <span>Найдено {{ $products->count() }} товаров</span>
                                    <div class="d-flex align-items-center">
                                        <span>Сортировать:</span>
                                        <select>
                                            <option value="по популярности">по популярности</option>
                                            <option value="по цене">по цене</option>
                                            <option value="по рейтингу">по рейтингу</option>
                                        </select>
                                        <button>
                                            <img src="/img/frontend/img/card-view.png" alt="card-view" class="card-view">
                                        </button>
                                        <button>
                                            <img src="/img/frontend/img/list-view.png" alt="list-view">
                                        </button>
                                    </div>
                                </div>
                                <div class="subcategory__main">
                                    @foreach($products as $product)
                                        @if($product->price > 0)
                                            <div class="subcategory__cell">
                                                <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                    <div class="subcategory__img">
                                                        <img src="{{ file_exists($product->image) ? asset($product->image) : asset('img/frontend/img/images-empty.png') }}" alt="photo">
                                                    </div>
                                                </a>
                                                <span class="subcategory__code">Код: {{ $product->article }} </span>
                                                <span class="subcategory__company">{{ $product->manufacturer }}</span>
                                                <span class="subcategory__type">{{ $product->name }}</span>
                                                <div class="d-flex align-items-end"><span class="subcategory__price">{{ $product->price }}<sup>грн</sup></span><span class="subcategory__price subcategory__price--old"><span>13898</span><sup>грн</sup></span></div>
                                                <p class="subcategory__sale">Вернем <span>1226 грн</span></p>
                                                <div class="subcategory__buy d-sm-none">
                                                    <add-to-cart
                                                        product="{{ $product }}"
                                                        action="{{ route('frontend.cart.add', $product->id) }}">
                                                        <div slot="button">
                                                            <button>Купить</button>
                                                        </div>
                                                    </add-to-cart>
                                                    <img src="{{ asset('img/frontend/img/svg/delivery-truck-green.svg') }}" alt="delivery-truck">
                                                    <span>В наличии</span>
                                                </div>
                                                <div class="subcategory__cell subcategory__cell--overlay">
                                                    <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                        <div class="subcategory__img">
                                                            <img src="{{ file_exists($product->image) ? asset($product->image) : asset('img/frontend/img/images-empty.png') }}" alt="photo">
                                                        </div>
                                                    </a>
                                                    <span class="subcategory__code">Код: {{ $product->article }} </span>
                                                    <span class="subcategory__company">{{ $product->manufacturer }}</span>
                                                    <span class="subcategory__type">{{ $product->name }}</span>
                                                    <div class="d-flex align-items-end"><span class="subcategory__price">{{ $product->price }}<sup>грн</sup></span><span class="subcategory__price subcategory__price--old"><span>13898</span><sup>грн</sup></span></div>
                                                    <p class="subcategory__sale">Вернем <span>1226 грн</span></p>
                                                    <div class="subcategory__buy">
                                                        <add-to-cart
                                                            product="{{ $product }}"
                                                            action="{{ route('frontend.cart.add', $product->id) }}">
                                                            <div slot="button">
                                                                <button>Купить</button>
                                                            </div>
                                                        </add-to-cart>
                                                        <img src="{{ file_exists($product->image) ? asset($product->image) : asset('img/frontend/img/images-empty.png') }}" alt="delivery-truck">
                                                        <span>В наличии</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="subcategory__cell subcategory__cell--na">
                                                <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                    <div class="subcategory__img">
                                                        <img src="{{ file_exists($product->image) ? asset($product->image) : asset('img/frontend/img/images-empty.png') }}" alt="photo">
                                                    </div>
                                                </a>
                                                <span class="subcategory__code">Код: {{ $product->article }} </span>
                                                <span class="subcategory__company">{{ $product->manufacturer }}</span>
                                                <span class="subcategory__type">{{ $product->name }}</span>
                                                <a href="#" class="subcategory__notify">Сообщить о поступлении</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="subcategory__footer">
								<span class="subcategory__total">
									Показано {{ $products->count() }} товаров из {{ $products->total() }}
								</span>
                                    {{ $products->appends(request()->all())->links('frontend.UiComponents.pagination.partfix') }}
                                </div>
{{--                                <div class="subcategory__more">--}}
{{--                                    <button>--}}
{{--                                        <div><img src="/img/frontend/img/svg/refresh2.svg" alt="refresh"></div>--}}
{{--                                        <span>загрузить еще 21 товар</span>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
                            </div>
                        @else
                            <p>Ничего не найдено...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="subcategory__links">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li>
                            <a href="#">Ссылка разовая</a>
                        </li>
                        <li>
                            <a href="#">Тормозные диск</a>
                        </li>
                        <li>
                            <a href="#">Колодки для буса</a>
                        </li>
                        <li>
                            <a href="#">Торможение 18</a>
                        </li>
                        <li>
                            <a href="#">Свежетормоз</a>
                        </li>
                        <li>
                            <a href="#">Коврик для торможения</a>
                        </li>
                        <li>
                            <a href="#">Дичайшее ПП</a>
                        </li>
                        <li>
                            <a href="#">Органический бочёк</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="subcategory__info">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! $category->description !!}
                </div>
            </div>
        </div>
    </section>
{{--    {!! app('ContentBlock')->render('content') !!}--}}
{{--    <section class="subcategory__info">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <h1>Заголовок h1</h1>--}}
{{--                    <p>Проведите профилактическое обслуживание и сделайте своевременный ремонт, увеличьте мощность и улучшите управляемость и торможение для улучшения общей производительности, и придайте вашему автомобилю, грузовику или внедорожнику уникальный внешний вид, при <a href="#">пример ссылки</a> котором головки будут поворачиваться, куда бы вы ни катились.</p>--}}
{{--                    <h2>Заголовок h2</h2>--}}
{{--                    <p>Вы можете сделать все это с помощью запчастей и аксессуаров CARiD. В отличие от некоторых он-лайн продавцов вторичного рынка, у которых есть запасные части, но они не могут помочь вам одеться или продать внешние аксессуары, но у вас нет колес и шин, которые вам нужны, чтобы завершить внешний вид, мы - универсальное направление для всех ваших автомобильных предметов первой необходимости.</p>--}}
{{--                    <h3>Заголовок h3</h3>--}}
{{--                    <p>Неважно, что вы хотите сделать со своим транспортным средством или где вы получаете свои удары - на улице, на трассе или на бездорожье - вы найдете качественные, фирменные запчасти и аксессуары на наших цифровых полках, чтобы превратить ваши автомобильные мечты в реальность.</p>--}}
{{--                    <div class="subcategory__table d-flex flex-column align-items-center">--}}
{{--                        <h3>Цены на тормозные колодки</h3>--}}
{{--                        <table>--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <td>Тормозные колодки</td>--}}
{{--                                <td>Цена</td>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>Тормозные колодки 1</td>--}}
{{--                                <td>123 грн</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>Тормозные колодки 2</td>--}}
{{--                                <td>123 грн</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>Тормозные колодки 3</td>--}}
{{--                                <td>123 грн</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>Тормозные колодки 4</td>--}}
{{--                                <td>123 грн</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>Тормозные колодки 5</td>--}}
{{--                                <td>123 грн</td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <h4 class="red">Заголовок h4</h4>--}}
{{--                    <p class="bold">Пример жирного текста</p>--}}
{{--                    <ul>--}}
{{--                        <li>Элемент списка 1</li>--}}
{{--                        <li>Элемент списка 2</li>--}}
{{--                        <li>Элемент списка 3</li>--}}
{{--                        <li>Элемент списка 4</li>--}}
{{--                    </ul>--}}
{{--                    <p class="cursive">Пример курсива</p>--}}
{{--                    <ol>--}}
{{--                        <li>Элемент списка 1</li>--}}
{{--                        <li>Элемент списка 2</li>--}}
{{--                        <li>Элемент списка 3</li>--}}
{{--                        <li>Элемент списка 4</li>--}}
{{--                    </ol>--}}
{{--                    <button class="hide">Скрыть</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <section class="last-goods pb30">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
                            <div class="d-flex align-items-center justify-content-between">
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
    @include('frontend.partials._advatages')
@endsection
