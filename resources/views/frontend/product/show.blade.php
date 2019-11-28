@section('meta_title', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-product-show.title', $meta_tags))
@section('meta_description', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-product-show.description', $meta_tags))
@section('meta_keywords', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-product-show.keywords', $meta_tags))
@extends('frontend')
@section('content')
    <section class="card">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! Breadcrumbs::render('frontend.product.show', $product) !!}
                    <div class="card__main">
                        @include('frontend.product.gallery', ['images' => $product->images])
                        <div class="card__main-right">
                            <h2>{{ $product->custom_attributes['name'] }} {{ $product->custom_attributes['manufacturer'] }} {{ $product->article }}</h2>
                            <span class="card__main-brand">
								Бренд:
								<a href="#">{{ $product->custom_attributes['manufacturer'] }}</a>
							</span>
                            <div class="d-flex align-items-center card__main-number">
                                <span>Оригинальный номер: {{ $product->article }}</span>
                                <button>Найти аналоги</button>
                            </div>
                            <div class="card__main-icons">
                                <div class="card__main-icon">
                                    <img src="/img/frontend/img/svg/shield2.svg" alt="shield2" class="icon">
                                    <div class="card__main-icon-dropdown">100% оригинал</div>
                                </div>
                                <div class="card__main-icon">
                                    <img src="/img/frontend/img/germany.png" alt="germany" class="icon">
                                    <div class="card__main-icon-dropdown">100% оригинал</div>
                                </div>
                                <div class="card__main-icon">
                                    <img src="/img/frontend/img/svg/return.svg" alt="return" class="icon">
                                    <div class="card__main-icon-dropdown">100% оригинал</div>
                                </div>
                                <div class="card__main-icon">
                                    <img src="/img/frontend/img/svg/percentage.svg" alt="percentage" class="icon">
                                    <div class="card__main-icon-dropdown">100% оригинал</div>
                                </div>
                            </div>
                            @if(env('APP_DEBUG'))
                                <div class="card__main-oldprice">
                                    <span>12 458</span>
                                    <sup>
                                        грн
                                    </sup>
                                </div>
                            @endif
                            <div class="d-flex align-items-start mb25">
                                <div class="d-flex flex-column">
                                    <span class="card__main-newprice">{{ $product->price }} <sup>грн</sup></span>
                                    @if(env('APP_DEBUG'))
                                        <p class="card__main-cashback">Кешбэк <span>12.8 грн</span></p>
                                    @endif
                                </div>
                                @if(isset($belongsModification) && $belongsModification)
                                    <div class="d-flex align-items-start card__main-suitable">
                                        <img src="/img/frontend/img/svg/car.svg" alt="car" class="card__main-suitable-car">
                                        <div class="d-flex flex-column">
                                            <span class="card__main-suitable-checked">
                                                <img src="/img/frontend/img/svg/checked.svg" alt="checked" class="icon">
                                            </span>
                                            <span class="card__main-suitable-caption">Подходит для вашего авто</span>
                                            <div class="d-flex align-items-center">
                                                <span class="card__main-suitable-model">{{ $activeCar->brand->description }} {{ $activeCar->model->description }} {{ $activeCar->year }}</span>
                                                <button class="card__main-suitable-change">Изменить</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex align-items-center">
{{--                                <div class="card__main-quantity">--}}
{{--                                    <span>4 шт.</span>--}}
{{--                                    <img src="/img/frontend/img/arrow-down.png" alt="arrow">--}}
{{--                                    <div class="card__main-quantity-dropdown">--}}
{{--                                        <span>1 шт.</span>--}}
{{--                                        <span>2 шт.</span>--}}
{{--                                        <span>3 шт.</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <add-to-cart
                                    product="{{ $product }}"
                                    action="{{ route('frontend.cart.add', $product->id) }}"
                                    quantity_select="true">
                                    <div slot="button">
                                        <a href="#" class="card__main-buy" @click.prevent>Купить</a>
                                    </div>
                                </add-to-cart>
                                <a href="#" class="card__main-credit">Купить в кредит</a>
                                <a href="#" class="card__main-featured"><img src="/img/frontend/img/svg/heart.svg" alt="heart"><span>В избранное</span></a>
                            </div>
                            <div class="card__main-stock">
                                <div class="card__main-stock-heading">
                                    <div>
                                        <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                                        <span class="green">В наличии</span>
                                        <span>на складе</span>
                                    </div>
                                </div>
                                <div class="card__main-stock-body">
                                    <div class="d-flex align-items-center card__main-stock-option">
                                        <img src="/img/frontend/img/svg/delivery-man.svg" alt="delivery-man" class="card__main-stock-icon">
                                        <div class="d-flex flex-column card__main-stock-w230">
                                            <span class="card__main-stock-delivery">Курьер по вашему адресу</span>
                                            <span class="card__main-stock-date">*Дата доставки - <b>29 августа</b></span>
                                        </div>
                                        <div class="d-flex align-items-end card__main-stock-nalozh">
                                            <p>Без комиссии<br/> за наложенный платеж</p>
                                            <img src="/img/frontend/img/svg/info.svg" alt="info">
                                        </div>
                                        <span class="card__main-stock-price free">Бесплатно</span>
                                    </div>
                                    <div class="d-flex align-items-center card__main-stock-option">
                                        <img src="/img/frontend/img/np.png" alt="np" class="card__main-stock-icon">
                                        <div class="d-flex flex-column card__main-stock-w230">
                                            <span class="card__main-stock-delivery">В отделение «Нова Пошта»</span>
                                            <span class="card__main-stock-date">*Дата доставки - <b>29 августа</b></span>
                                        </div>
                                        <div class="d-flex align-items-end card__main-stock-nalozh">
                                            <p>Без комиссии<br/> за наложенный платеж</p>
                                            <img src="/img/frontend/img/svg/info.svg" alt="info">
                                        </div>
                                        <span class="card__main-stock-price">50 грн</span>
                                    </div>
                                    <div class="d-flex align-items-center card__main-stock-option">
                                        <img src="/img/frontend/img/intime.png" alt="intime" class="card__main-stock-icon">
                                        <div class="d-flex flex-column card__main-stock-w230">
                                            <span class="card__main-stock-delivery">В отделение «ИнТайм»</span>
                                            <span class="card__main-stock-date">*Дата доставки - <b>29 августа</b></span>
                                        </div>
                                        <div class="d-flex align-items-end card__main-stock-nalozh">
                                            <p>Без комиссии<br/> за наложенный платеж</p>
                                            <img src="/img/frontend/img/svg/info.svg" alt="info">
                                        </div>
                                        <span class="card__main-stock-price">50 грн</span>
                                    </div>
                                    <p class="card__main-stock-info">* Дата доставки носит информационый характер и является ориентировочной. Точную дату доставки
                                        вы узнаете после подтверждения заказа</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center card__main-right-consultation">
                                <img src="/img/frontend/img/avatar.png" alt="avatar" class="avatar">
                                <div class="d-flex flex-column">
                                    <p>Остались вопросы? Специалист ответит</p>
                                    <div class="d-flex align-items-center">
                                        <img src="/img/frontend/img/svg/telephone2.svg" alt="telephone" class="icon">
                                        <a href="#">(067) 123-45-67</a>
                                        <button>Начать чат</button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="card__main-option">
                                    <img src="/img/frontend/img/svg/shield4.svg" alt="shield4">
                                    <span>Гарантия</span>
                                </div>
                                <div class="card__main-option">
                                    <img src="/img/frontend/img/svg/money1.svg" alt="money1">
                                    <span>Оплата</span>
                                    <ul class="card__main-option-dropdown">
                                        <li>Наличными</li>
                                        <li>Visa/MasterCard</li>
                                        <li>Кредит</li>
                                        <li>Оплата частями</li>
                                        <li>Безналичными</li>
                                    </ul>
                                </div>
                                <div class="card__main-option">
                                    <img src="/img/frontend/img/svg/delivery-truck1.svg" alt="delivery-truck">
                                    <span>Доставка</span>
                                </div>
                                <div class="card__main-option">
                                    <img src="/img/frontend/img/svg/refresh1.svg" alt="refresh">
                                    <span>Возврат</span>
                                </div>
                                <div class="card__main-option">
                                    <img src="/img/frontend/img/svg/grn.svg" alt="grn">
                                    <span>Бонусы</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card__white last-goods">
                        <h2 class="default-title">
                            предложения совместимых Аналогов
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
                        </div>
                    </div>
                    <ul class="card__tabs">
                        <li><a href="#">Все о товаре</a></li>
                        <li><a href="#">Фото и видео</a></li>
                        <li><a href="#">Отзывы и вопросы</a></li>
                        <li><a href="#">Рекомендуемые товары</a></li>
                    </ul>
                    <div class="card__info">
                        <div class="card__info-body">
                            <p>Предоставляем возможность выбрать и заказать Тормозные колодки Dello 30105660234 по самой оптимальной цене среди каталогов автомобильных запчастей в Киеве и Украине.</p>
                            <p>Тормозные колодки Dello 30105660234 - это отличный вариант покупки для таких брендов авто, как Форд, Ленд Ровер, Вольво. Интернет каталог укрпартс.ком.юа готов предложить Вам деталь по выгодной цене от 411 грн., а также её заменители. Наши сотрудники организуют продажу с доставкой покупателям из регионов Харькова, Никополя, Херсона, Краматорска, Полтавы, Сум и в любой город Украины.</p>
                            <h3>Технические характеристики <span>Тормозные колодки Dello 30105660234</span></h3>
                            <div class="card__info-data">
                                <div class="d-flex align-items-center justify-content-between">
									<span>
										Гарантия
									</span>
                                    <span>
										12 мес.
									</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
									<span>
										Интернет
									</span>
                                    <span>
										4G (LTE); 3G
									</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
									<span>
										Матрица
									</span>
                                    <span>
										IPS
									</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
									<span>
										Пикселей на дюйм
									</span>
                                    <span>
										282 ppi
									</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
									<span>
										Количество ядер
									</span>
                                    <span>
										4
									</span>
                                </div>
                            </div>
                            <h3>Применимость к автомобилям</h3>
                            <div class="companies__catalog d-flex flex-column">
                                <div class="d-flex">
                                    <div class="companies__catalog-block">
										<span class="companies__catalog-letter">
											A
										</span>
                                        <ul>
                                            <li><a href="#">Acura</a></li>
                                            <li><a href="#">Alfa romeo</a></li>
                                            <li><a href="#">Audi</a></li>
                                        </ul>
                                    </div>
                                    <div class="companies__catalog-block">
										<span class="companies__catalog-letter">
											H
										</span>
                                        <ul>
                                            <li><a href="#">Honda</a></li>
                                            <li><a href="#">Hummer</a></li>
                                            <li><a href="#">Hyundai</a></li>
                                        </ul>
                                    </div>
                                    <div class="companies__catalog-block">
										<span class="companies__catalog-letter">
											I
										</span>
                                        <ul>
                                            <li><a href="#">Infiniti</a></li>
                                            <li><a href="#">Isuzu</a></li>
                                            <li><a href="#">Iveco</a></li>
                                        </ul>
                                    </div>
                                    <div class="companies__catalog-block">
										<span class="companies__catalog-letter">
											J
										</span>
                                        <ul>
                                            <li><a href="#">Jaguar</a></li>
                                            <li><a href="#">Jeep</a></li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="d-flex">
                                    <div class="companies__catalog-block">
										<span class="companies__catalog-letter">
											B
										</span>
                                        <ul>
                                            <li><a href="#">Bentley</a></li>
                                            <li><a href="#">BMW</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card__code">
                                <span>Артикулы:</span>
                                <div class="d-flex flex-column">
                                    <a href="#">C2G017ABE</a>
                                    <a href="#">C2-G-017 ABE</a>
                                    <a href="#">C2G-017 ABE</a>
                                    <a href="#">C2 G 017 ABE</a>
                                </div>
                            </div>
                        </div>
                        <div class="card__info-sidebar">
                            <a href="#" class="card__info-article">
                                <img src="/img/frontend/img/article1.png" alt="article">
                                <span>Как снизить расходы на содержание автомобиля: 5 действенных способов</span>
                            </a>
                            <a href="#" class="card__info-article">
                                <img src="/img/frontend/img/article2.png" alt="article">
                                <span>Что означают цветные метки на шинах</span>
                            </a>
                            <a href="#" class="card__info-article">
                                <img src="/img/frontend/img/article3.png" alt="article">
                                <span>Как снизить расходы на содержание автомобиля: 5 действенных способов</span>
                            </a>
                            <div class="card__info-help">
                                <h2>Нужна помощь?</h2>
                                <p>Поможем подобрать товар и ответим на любые вопросы</p>
                                <a href="#">+38 (050) 385-58-88</a>
                                <a href="#">+38 (067) 570-50-51</a>
                                <a href="#">+38 (044) 390-98-99</a>
                                <a href="#" class="card__info-call">
                                    Перезвоните мне
                                    <span><img src="/img/frontend/img/svg/telephone3.svg" alt="telephone" class="icon"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <section class="advantages">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex">
                    <div class="advantages__block">
                        <img class="icon advantages__icon" src="/img/frontend/img/svg/question.svg" />
                        <div class="d-flex flex-column">
                            <h3>Центр поддержки</h3>
                            <p>По телефону или в мессенджерах</p>
                        </div>
                    </div>
                    <div class="advantages__block">
                        <img class="icon advantages__icon" src="/img/frontend/img/svg/pay.svg" />
                        <div class="d-flex flex-column">
                            <h3>Возврат в течении 14 дней</h3>
                            <p>Без объяснения причины</p>
                        </div>
                    </div>
                    <div class="advantages__block">
                        <img class="icon advantages__icon" src="/img/frontend/img/svg/payment-method.svg" />
                        <div class="d-flex flex-column">
                            <h3>Оплата при получении</h3>
                            <p>После осмотра и проверки целостности</p>
                        </div>
                    </div>
                    <div class="advantages__block">
                        <img class="icon advantages__icon" src="/img/frontend/img/svg/delivery-truck.svg" />
                        <div class="d-flex flex-column">
                            <h3>Доставка до 2 дней</h3>
                            <p>На точку выдачи или адресная доставка</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{--    <div class="container">--}}
{{--        <product-show product="{{ $product }}" add_action="{{ route('frontend.cart.add', $product->id) }}"></product-show>--}}
{{--        @if($product->images->count())--}}
{{--            <div>--}}
{{--                цена: {{ $product->getAttrValue('price') }}--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                {{ $product->getAttrValue('short_description') }}--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                {{ $product->getAttrValue('description') }}--}}
{{--            </div>--}}
{{--            @foreach($product->images as $image)--}}
{{--                <img style="max-width: 100px" src="/{{ $image->path.$product->id."/".$image->name }}" alt="">--}}
{{--            @endforeach--}}
{{--            <form action="{{ route('frontend.cart.add', $product->id) }}" method="POST">--}}
{{--                @csrf--}}
{{--                <input type="hidden" name="product" value="{{ $product->id }}">--}}
{{--                <input type="hidden" name="quantity" value="1">--}}
{{--                <button class="btn btn-primary">Add to cart</button>--}}
{{--            </form>--}}
{{--        @endif--}}
{{--    </div>--}}
@endsection
