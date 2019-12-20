<popup-black-layout></popup-black-layout>
<search :add_action="'{{ route('frontend.cart.add', PRODUCT_MARK_FOR_REPLACING) }}'"
        :marker="'{{ PRODUCT_MARK_FOR_REPLACING }}'"></search>
<section class="pre-header">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="pre-header__phone">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('img/frontend/img/svg/telephone2.svg') }}" alt="telephone" class="telephone">
                        <a href="tel:+380671234567">(067) 123-45-67</a>
                        <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img">
                        <div class="pre-header__phone-dropdown">
                            <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>
                            <h3>Контактные телефоны</h3>
                            <p>Консультации и заказ по телефонам:</p>
                            <div class="d-flex flex-wrap">
                                <a href="tel:+380671234567">(067) 123-45-67</a>
                                <a href="tel:+380671234567">(067) 123-45-67</a>
                                <a href="tel:+380671234567">(067) 123-45-67</a>
                            </div>
                            <p>График работы call-центра:</p>
                            <div class="d-flex justify-content-between mb10">
                                <span>В будние:</span>
                                <span>с 8:00 до 21:00</span>
                            </div>
                            <div class="d-flex justify-content-between mb10">
                                <span>Суббота:</span>
                                <span>с 9:00 до 20:00</span>
                            </div>
                            <div class="d-flex justify-content-between mb10">
                                <span>Воскресенье:</span>
                                <span>c 10:00 до 19:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7 col-xl-6">
                <nav>
                    <ul class="pre-header__menu">
                        <li><a href="#">Оплата и доставка</a></li>
                        <li><a href="#">Гарантия и возврат</a></li>
                        <li><a href="#">Помощь</a></li>
                        <li><a href="#">Поставщикам</a></li>
                        <li><a href="#">Контакты</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-3 col-xl-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="pre-header__language">
                        <div class="d-flex align-items-center">
                            <span class="pre-header__language-title">Русский</span>
                            <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img">
                            <div class="pre-header__language-dropdown">
                                <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>
                                <h3>Язык сайта</h3>
                                <a href="#">Русский</a>
                                <a href="#">Украинский</a>
                            </div>
                        </div>
                    </div>
                    <div class="pre-header__profile">
                        <div class="d-flex align-items-center">
                            <span class="pre-header__profile-title">Мой профиль</span>
                            <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img">
                            <form class="pre-header__profile-dropdown">
                                <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>
                                <h3>Профиль покупателя</h3>
                                <p>Не зарегистрированы на Partfix? <a href="#">Зарегистрироваться</a></p>
                                <h3>Войти</h3>
                                <div class="pre-header__profile-input">
                                    <input type="text" placeholder="Номер телефона">
                                </div>
                                <div class="pre-header__profile-input d-flex align-items-center">
                                    <input type="password" placeholder="Пароль">
                                    <a href="#">Я забыл</a>
                                </div>
                                <div class="d-flex align-items-center pre-header__profile-login">
                                    <button type="submit">Войти</button>
                                    <span>или войти через</span>
                                    <a href="#" class="pre-header__profile-social facebook"><img src="{{ asset('img/frontend/img/facebook.png') }}" alt="facebook" class="facebook"></a>
                                    <a href="#" class="pre-header__profile-social google"><img src="{{ asset('img/frontend/img/google.png') }}" alt="google" class="google"></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<section class="pre-header">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-2">--}}
{{--                <div class="pre-header__phone">--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                        <img src="{{ asset('img/frontend/img/svg/telephone2.svg') }}" alt="telephone" class="telephone">--}}
{{--                        <a href="tel:+380671234567">(067) 123-45-67</a>--}}
{{--                        <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img">--}}
{{--                        <div class="pre-header__phone-dropdown">--}}
{{--                            <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>--}}
{{--                            <h3>Контактные телефоны</h3>--}}
{{--                            <p>Консультации и заказ по телефонам:</p>--}}
{{--                            <div class="d-flex flex-wrap">--}}
{{--                                <a href="tel:+380671234567">(067) 123-45-67</a>--}}
{{--                                <a href="tel:+380671234567">(067) 123-45-67</a>--}}
{{--                                <a href="tel:+380671234567">(067) 123-45-67</a>--}}
{{--                            </div>--}}
{{--                            <p>График работы call-центра:</p>--}}
{{--                            <div class="d-flex justify-content-between mb10">--}}
{{--                                <span>В будние:</span>--}}
{{--                                <span>с 8:00 до 21:00</span>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex justify-content-between mb10">--}}
{{--                                <span>Суббота:</span>--}}
{{--                                <span>с 9:00 до 20:00</span>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex justify-content-between mb10">--}}
{{--                                <span>Воскресенье:</span>--}}
{{--                                <span>c 10:00 до 19:00</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                <nav>--}}
{{--                    <ul class="pre-header__menu">--}}
{{--                        <li><a href="#">Оплата и доставка</a></li>--}}
{{--                        <li><a href="#">Гарантия и возврат</a></li>--}}
{{--                        <li><a href="#">Помощь</a></li>--}}
{{--                        <li><a href="#">Поставщикам</a></li>--}}
{{--                        <li><a href="#">Контакты</a></li>--}}
{{--                    </ul>--}}
{{--                </nav>--}}
{{--            </div>--}}
{{--            <div class="col-4">--}}
{{--                <div class="d-flex align-items-center justify-content-end">--}}
{{--                    <div class="pre-header__language">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <span class="pre-header__language-title">Русский</span>--}}
{{--                            <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img">--}}
{{--                            <div class="pre-header__language-dropdown">--}}
{{--                                <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>--}}
{{--                                <h3>Язык сайта</h3>--}}
{{--                                <a href="#">Русский</a>--}}
{{--                                <a href="#">Украинский</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="pre-header__profile">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <span class="pre-header__profile-title">Мой профиль</span>--}}
{{--                            <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img">--}}
{{--                            <form class="pre-header__profile-dropdown">--}}
{{--                                <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>--}}
{{--                                <h3>Профиль покупателя</h3>--}}
{{--                                <p>Не зарегистрированы на Partfix? <a href="#">Зарегистрироваться</a></p>--}}
{{--                                <h3>Войти</h3>--}}
{{--                                <div class="pre-header__profile-input">--}}
{{--                                    <input type="text" placeholder="Номер телефона">--}}
{{--                                </div>--}}
{{--                                <div class="pre-header__profile-input d-flex align-items-center">--}}
{{--                                    <input type="password" placeholder="Пароль">--}}
{{--                                    <a href="#">Я забыл</a>--}}
{{--                                </div>--}}
{{--                                <div class="d-flex align-items-center pre-header__profile-login">--}}
{{--                                    <button type="submit">Войти</button>--}}
{{--                                    <span>или войти через</span>--}}
{{--                                    <a href="#" class="pre-header__profile-social facebook"><img src="{{ asset('img/frontend/img/facebook.png') }}" alt="facebook" class="facebook"></a>--}}
{{--                                    <a href="#" class="pre-header__profile-social google"><img src="{{ asset('img/frontend/img/google.png') }}" alt="google" class="google"></a>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
<header class="header">
    <div class="container">
        <div class="row mb40 v-cloak--hidden">
            <div class="header__popup-catalog">
                <h3>Каталог запчастей на Mercedes GLA-CLASS (X156) 2012</h3>
                <div class="d-flex align-items-center">
                    <div class="header__popup-catalog-main">
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Запчасти для ТО</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Тормозная система</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Кузов и составляющие</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Двигатель</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Выхлопная система</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Подвеска и рулевое</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Коробка передач</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Охлаждение и отопление</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Электрика и освещение</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                        <div class="header__popup-catalog-item">
                            <img src="{{ asset('img/frontend/img/catalog-img.png') }}" alt="catalog">
                            <div class="d-flex flex-column">
                                <a href="#">Масла</a>
                                <p>Фильтры, масла, колодки, аккумуляторы</p>
                            </div>
                        </div>
                    </div>
                    <div class="header__popup-catalog-bonus">
                        <span class="item">Амортизаторы KYB с дополнительным бонусом при покупке</span>
                        <div>
                            <img src="{{ asset('img/frontend/img/item4.png') }}" alt="item">
                            <div class="sale">
                                <span>+20%</span>
                                бонусов
                            </div>
                        </div>
                        <a href="#">Подробнее</a>
                    </div>
                </div>
            </div>
            @include('frontend.partials._logo')
            <div class="col-10 d-flex align-items-center">
                <search-button></search-button>
                <div class="header__punkt header__menu-mobile">
                    <img src="{{ asset('img/frontend/img/menu-black.png') }}" alt="menu">
                    <div class="header__menu-mobile-dropdown">
                        <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>
                        <ul class="pre-footer__contacts-menu d-block">
                            <li>
                                <img src="{{ asset('img/frontend/img/svg/telephone.svg') }}" alt="telephone">
                                <div class="d-flex flex-column">
                                    <a href="tel:+380673455567">(067) 345-55-67</a>
                                    <a href="tel:+380503455567">(050) 345-55-67</a>
                                </div>
                            </li>
                            <li class="align-items-center justify-content-between">
                                <div class="d-flex align-items-center"><img src="{{ asset('img/frontend/img/svg/speech-bubble.svg') }}" alt="telephone">
                                    <button>Начать чат</button></div>
                                <div class="pre-header__language">
                                    <div class="d-flex align-items-center">
                                        <span class="pre-header__language-title">Русский</span>
                                        <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img" class="widthUnset">
                                        <div class="pre-header__language-dropdown">
                                            <h3>Язык сайта</h3>
                                            <a href="#">Русский</a>
                                            <a href="#">Украинский</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <?php $rubrics = \App\Models\Content\Rubric\Rubric::menu()->select('title', 'slug', 'id')->get() ?>
                        @if($rubrics->count())
                        <h3>Каталог товаров</h3>
                        @endif
                        <h3>Информация</h3>
                        <ul class="header__menu">
                            <li><a href="#">Мой профиль</a></li>
                            <li><a href="#">Оплата и доставка</a></li>
                            <li><a href="#">Гарантия и возврат</a></li>
                            <li><a href="#">Помощь</a></li>
                            <li><a href="#">Поставщикам</a></li>
                            <li><a href="#">Контакты</a></li>
                        </ul>
                    </div>
                </div>
                <garage :new_garage="{{ json_encode(app('App\Classes\Garage')->getGarage()) }}"></garage>
                <div class="header__punkt header__user">
                    <img src="{{ asset('img/frontend/img/svg/user.svg') }}" alt="user" class="icon">
                </div>
                <div class="header__punkt header__featured">
                    <img src="{{ asset('img/frontend/img/svg/heart.svg') }}" alt="heart" class="icon">
                    <span class="header__punkt-counter">96</span>
                    <span class="header__punkt-title">Избранное</span>
                    <img src="{{ asset('img/frontend/img/arrow-down.png') }}" alt="img" class="arrow">
                    <div class="header__featured-dropdown">
                        <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>
                        <h3>Избранное</h3>
                        <div class="header__featured-dropdown-item">
                            <img src="{{ asset('img/frontend/img/cart-item.png') }}" alt="cart-item" class="header__featured-dropdown-item-img">
                            <div class="d-flex flex-column">
                                <a href="#" class="header__featured-dropdown-title">Тормозные колодки стальные круглые крас...</a>
                                <span class="header__featured-dropdown-code">Артикул: 3400043</span>
                                <span class="header__featured-dropdown-company">SASIC</span>
                            </div>
                            <button class="header__featured-dropdown-item-delete"><img src="{{ asset('img/frontend/img/trash.png') }}" alt="trash"></button>
                        </div>
                        <div class="header__featured-dropdown-item">
                            <img src="{{ asset('img/frontend/img/cart-item.png') }}" alt="cart-item" class="header__featured-dropdown-item-img">
                            <div class="d-flex flex-column">
                                <a href="#" class="header__featured-dropdown-title">Тормозные колодки стальные круглые крас...</a>
                                <span class="header__featured-dropdown-code">Артикул: 3400043</span>
                                <span class="header__featured-dropdown-company">SASIC</span>
                            </div>
                            <button class="header__featured-dropdown-item-delete"><img src="{{ asset('img/frontend/img/trash.png') }}" alt="trash"></button>
                        </div>
                    </div>
                </div>
                @include('frontend.partials._cart')
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-3 col-lg-1 col-xl-2">
                <button class="header__catalog">
                    <img src="{{ asset('img/frontend/img/catalog.png') }}" alt="icon">
                    <span>Каталог товаров</span>
                </button>
            </div>
            <div class="col-6 d-lg-none d-flex justify-content-center">
                <a class="header__logo" href="{{ route('frontend.index') }}">
                    {!! app('ContentBlock')->render('partfix-logo') !!}
                </a>
            </div>
            <mobile-search-button></mobile-search-button>
            <div class="col-10">
                <ul class="header__menu">
                    @include('partfix\nav::frontend._nav')
                    <li class="sale">
                        <a href="#">
                            <img src="{{ asset('img/frontend/img/fire.png') }}" alt="fire">
                            Скидки
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
