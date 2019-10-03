@extends('frontend')
@section('content')
    <div class="v-cloak--hidden">
        <checkout :app_cart="'{{ $cart  = app('App\Models\Cart\CartInterface')->getCart() }}'">
            @if($cart)
                <div slot="content">
                    <div class="d-flex">
                        <div class="checkout__body">
                            @if(!auth()->user())
                                @include('frontend.checkout.checkout-user-info-form')
                            @endif
                            <div class="checkout__block">
                                <h2 class="checkout__subtitle">
                                    Способ доставки
                                </h2>
                                <div class="d-flex align-items-center checkout__pay checkbox-round-checked">
                                    <div class="checkbox checkbox-round">
                                        <span></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="/img/frontend/img/svg/delivery-man.svg" alt="delivery-man" class="icon">
                                        <div class="d-flex flex-column checkout__w200">
											<span class="checkbox__title">
												Курьер по вашему адресу
											</span>
                                            <span class="checkbox__date">
												*Дата доставки - <b>29 августа</b>
											</span>
                                        </div>
                                        <span class="checkout__delivery free">Бесплатно</span>
                                    </div>
                                </div>
                                <div class="checkout__input checkout__delivery-input">
                                    <p>Адрес доставки</p>
                                    <div class="d-flex align-items-center">
                                        <input type="text" placeholder="Город, улица, дом, подьезд, квартира/офис">
                                        <span>Ошибка: Введите имя</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center checkout__pay">
                                    <div class="checkbox checkbox-round">
                                        <span></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="/img/frontend/img/np.png" alt="np" class="icon">
                                        <div class="d-flex flex-column checkout__w200">
											<span class="checkbox__title">
												В отделении "Нова Пошта"
											</span>
                                            <span class="checkbox__date">
												*Дата доставки - <b>29 августа</b>
											</span>
                                        </div>
                                        <span class="checkout__delivery">50 грн</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center checkout__pay">
                                    <div class="checkbox checkbox-round">
                                        <span></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="/img/frontend/img/intime.png" alt="intime" class="icon">
                                        <div class="d-flex flex-column checkout__w200">
											<span class="checkbox__title">
												В отделении "ИнТайм"
											</span>
                                            <span class="checkbox__date">
												*Дата доставки - <b>29 августа</b>
											</span>
                                        </div>
                                        <span class="checkout__delivery">50 грн</span>
                                    </div>
                                </div>
                                <p class="checkout__delivery-info">* Дата доставки носит информационый характер и является ориентировочной. Точную дату доставки<br/>
                                    вы узнаете после подтверждения заказа</p>
                            </div>
                            <div class="checkout__block">
                                <h2 class="checkout__subtitle">
                                    Способ оплаты
                                </h2>
                                <div class="d-flex align-items-center checkout__pay checkbox-round-checked">
                                    <div class="checkbox checkbox-round">
                                        <span></span>
                                    </div>
                                    <div class="d-flex">
                                        <img src="/img/frontend/img/svg/wallet2.svg" alt="wallet2" class="icon">
                                        <div class="d-flex flex-column">
											<span class="checkbox__title">
												Наличными
											</span>
                                            <span class="checkbox__date">
												*Дата доставки - <b>29 августа</b>
											</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center checkout__pay">
                                    <div class="checkbox checkbox-round">
                                        <span></span>
                                    </div>
                                    <div class="d-flex">
                                        <img src="/img/frontend/img/svg/credit-card2.svg" alt="credit-card2" class="icon">
                                        <div class="d-flex flex-column">
											<span class="checkbox__title">
												Visa/Mastercard или Приват24
											</span>
                                            <span class="checkbox__date">
												*Дата доставки - <b>29 августа</b>
											</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center checkout__pay">
                                    <div class="checkbox checkbox-round">
                                        <span></span>
                                    </div>
                                    <div class="d-flex">
                                        <img src="/img/frontend/img/svg/cash.svg" alt="cash" class="icon">
                                        <div class="d-flex flex-column">
											<span class="checkbox__title">
												В кредит
											</span>
                                            <span class="checkbox__date">
												*Дата доставки - <b>29 августа</b>
											</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__block">
                                <div class="d-flex align-items-center mb25">
                                    <img src="/img/frontend/img/svg/speech-bubble.svg" alt="speech-bubble" class="icon">
                                    <a href="#">Комментарий к заказу</a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="checkbox checked">
                                        <img src="/img/frontend/img/svg/checked.svg" alt="checked">
                                    </div>
                                    <span>Перезвоните мне для уточнения деталей заказа</span>
                                </div>
                            </div>
                        </div>
                        @include('frontend.checkout.cart', ['cart' => $cart])
                    </div>
                    {{--                <div class="row">--}}
                    {{--                    <div class="col-md-8">--}}
                    {{--                        <div class="row">--}}
                    {{--                            @if(!auth()->user())--}}
                    {{--                                @include('frontend.checkout.checkout-user-info-form')--}}
                    {{--                            @endif--}}
                    {{--                        </div>--}}
                    {{--                        <div class="row">--}}
                    {{--                            @include('frontend.checkout.checkout-order-comment')--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="col-md-4">--}}
                    {{--                        @include('frontend.checkout.cart', ['cart' => $cart])--}}
                    {{--                    </div>--}}
                    {{--                </div>--}}
                </div>
            @endif
        </checkout>
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
    </div>

{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <checkout :app_cart="'{{ $cart  = app('App\Models\Cart\CartInterface')->getCart() }}'">--}}
{{--                @if($cart)--}}
{{--                    <div slot="content">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-8">--}}
{{--                                <div class="row">--}}
{{--                                    @if(!auth()->user())--}}
{{--                                        @include('frontend.checkout.checkout-user-info-form')--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    @include('frontend.checkout.checkout-order-comment')--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                @include('frontend.checkout.cart', ['cart' => $cart])--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </checkout>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
