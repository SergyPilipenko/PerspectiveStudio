@section('meta_title', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-index.title', ['title' => 'запчасти']))
@section('meta_description', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-index.description', ['description' => 'еще что-то']))
@section('meta_keywords', app('MetaTags')->getMetaTag('meta-tags::meta.frontend-index.keywords', ['keywords' => 'хз']))
@extends('frontend')
@section('content')
    <section class="search" style="min-height: 458px">
        <div class="container">
            <div class="row">
                @include('frontend.UiComponents.frontpage.search-tabs')
            </div>
        </div>
    </section>
    @include('partfix\viewed-products::viewed-products')
    <section class="companies">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="default-title">
                        Автозапчасти для любой марки автомобиля
                    </h2>
{{--                    @foreach($alphabeticalBrands as $key => $items)--}}
{{--                        <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										{{ $key }}--}}
{{--									</span>--}}
{{--                            <ul>--}}
{{--                                @foreach($items as $item)--}}
{{--                                    <li><a href="#">{{ $item->description }}</a></li>--}}
{{--                                                                            <li><a href="#">Alfa romeo</a></li>--}}
{{--                                                                            <li><a href="#">Audi</a></li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="companies__catalog">
                            <?php $i = 0; $x = 0; ?>
                            @foreach($alphabeticalBrands as $key => $items)
                                @if($i % 6 == 0)
                                    <div class="d-flex flex-column {{ $x >= 5 ? 'hidden' : '' }}">
                                @endif
                                        <div class="companies__catalog-block">
									<span class="companies__catalog-letter">
										{{ $key }}
									</span>
                                            <ul>
                                                @foreach($items as $item)
                                                <li><a href="#">{{ $item->description }}</a></li>
                                                @endforeach
{{--                                                <li><a href="#">Alfa romeo</a></li>--}}
{{--                                                <li><a href="#">Audi</a></li>--}}
                                            </ul>
                                        </div>
                                @if($i % 6 == 0)
                                    </div>
                                @endif
                                <?php $x++ ?>
                            @endforeach
{{--                            <div class="d-flex flex-column">--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										A--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Acura</a></li>--}}
{{--                                        <li><a href="#">Alfa romeo</a></li>--}}
{{--                                        <li><a href="#">Audi</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										B--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Bentley</a></li>--}}
{{--                                        <li><a href="#">BMW</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										C--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Cadillac</a></li>--}}
{{--                                        <li><a href="#">Chevrolet</a></li>--}}
{{--                                        <li><a href="#">Chrysler</a></li>--}}
{{--                                        <li><a href="#">Citroën</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										D--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Daewoo</a></li>--}}
{{--                                        <li><a href="#">Dodge</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										F--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Fiat</a></li>--}}
{{--                                        <li><a href="#">Ford</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										G--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Gaz</a></li>--}}
{{--                                        <li><a href="#">Geely</a></li>--}}
{{--                                        <li><a href="#">Great wall</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex flex-column">--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										H--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Honda</a></li>--}}
{{--                                        <li><a href="#">Hummer</a></li>--}}
{{--                                        <li><a href="#">Hyundai</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										I--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Infiniti</a></li>--}}
{{--                                        <li><a href="#">Isuzu</a></li>--}}
{{--                                        <li><a href="#">Iveco</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										J--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Jaguar</a></li>--}}
{{--                                        <li><a href="#">Jeep</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block active">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										K--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Kia</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										L--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Lada</a></li>--}}
{{--                                        <li><a href="#">Land rover</a></li>--}}
{{--                                        <li><a href="#">Lexus</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										M--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Mazda</a></li>--}}
{{--                                        <li><a href="#">Mercedes-benz</a></li>--}}
{{--                                        <li><a href="#">Mini</a></li>--}}
{{--                                        <li><a href="#">Mitsubishi</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex flex-column">--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										N--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Nissan</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										O--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Opel</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										P--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Peugeot</a></li>--}}
{{--                                        <li><a href="#">Porsche</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										R--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Renault</a></li>--}}
{{--                                        <li><a href="#">Rover</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										S--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Saab</a></li>--}}
{{--                                        <li><a href="#">Seat</a></li>--}}
{{--                                        <li><a href="#">Skoda</a></li>--}}
{{--                                        <li><a href="#">Smart</a></li>--}}
{{--                                        <li><a href="#">Ssangyong</a></li>--}}
{{--                                        <li><a href="#">Subaru</a></li>--}}
{{--                                        <li><a href="#">Suzuki</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										T--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Toyota</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										V--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Volvo</a></li>--}}
{{--                                        <li><a href="#">Vw</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <a href="#" class="companies__catalog-show"><span>Показать все</span></a>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="companies__block">
                                <h3><span>Нужна консультация?</span></h3>
                                <p>Оставьте нам ваш VIN-код или фото с винкодом, наш консультант поможет выбрать подходящие запчасти.</p>
                                <form class="companies__block-form">
                                    <div class="d-flex align-items-center align-items-sm-start align-items-md-center flex-column flex-md-row">
                                        <div class="d-flex align-items-center companies__block-form-line mt0">
                                            <img src="{{ asset('img/frontend/img/svg/id.svg') }}" alt="telephone" class="icon companies__block-icon">
                                            <input type="text" placeholder="VIN код">
                                        </div>
                                        <span class="companies__block-form-or">или</span>
                                        <button class="pl35">
                                            <span><img src="{{ asset('img/frontend/img/svg/upload-to-arrow.svg') }}" alt="upload-to-arrow"></span>
                                            фото техпаспорта
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center companies__block-form-line">
                                        <img src="{{ asset('img/frontend/img/svg/mobile-phone.svg') }}" alt="telephone" class="icon companies__block-icon">
                                        <input type="tel" placeholder="Номер телефона">
                                    </div>
                                    <div class="d-flex align-items-center companies__block-form-line">
                                        <img src="{{ asset('img/frontend/img/svg/telephone3.svg') }}" alt="telephone" class="icon companies__block-icon">
                                        <div class="companies__block-form-contacts">
                                            <!-- <input type="text" placeholder="Удобный способ связи"> -->
                                            <span>Удобный способ связи</span>
                                            <img src="{{ asset('img/frontend/img/triangle.png') }}" alt="triangle" class="arrow">
                                            <div class="companies__block-form-contacts-dropdown">
                                                <div>
                                                    <img src="{{ asset('img/frontend/img/svg/telephone3.svg') }}" alt="telephone">
                                                    <span>Телефон</span>
                                                </div>
                                                <div>
                                                    <img src="{{ asset('img/frontend/img/svg/viber.svg') }}" alt="viber">
                                                    <span>Viber</span>
                                                </div>
                                                <div>
                                                    <img src="{{ asset('img/frontend/img/svg/whatsapp.svg') }}" alt="whatsapp">
                                                    <span>WhatsApp</span>
                                                </div>
                                                <div>
                                                    <img src="{{ asset('img/frontend/img/svg/telegram_logo.svg') }}" alt="telegram">
                                                    <span>Telegram</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="companies__block-form-submit">
                                        Отправить запрос
                                    </button>
                                </form>
                            </div>
                            <div class="companies__block pb80">
                                <h3><span>Зарегистрируйтесь</span> на Partfix и вы сможете:</h3>
                                <ul>
                                    <li>
                                        <img src="{{ asset('img/frontend/img/svg/car.svg') }}" alt="car">
                                        <span>Сохранить ваши автомобили в «гараж» и находить их быстрее</span>
                                    </li>
                                    <li>
                                        <img src="{{ asset('img/frontend/img/svg/money.svg') }}" alt="money">
                                        <span>Накапливать бонусы за покупки</span>
                                    </li>
                                    <li>
                                        <img src="{{ asset('img/frontend/img/svg/refresh.svg') }}" alt="refresh">
                                        <span>Повторять заказы из вашей истории</span>
                                    </li>
                                    <li>
                                        <img src="{{ asset('img/frontend/img/svg/notification.svg') }}" alt="notification">
                                        <span>Получать уведомления об акциях и спецпредложениях</span>
                                    </li>
                                </ul>
                                <form class="d-flex align-items-center companies__block-contact">
                                    <input type="tel" placeholder="+38 (0__) ___-___-___" required>
                                    <button type="submit">Зарегистрироваться</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{--    <section class="companies">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <h2 class="default-title">--}}
{{--                        Автозапчасти для любой марки автомобиля--}}
{{--                    </h2>--}}
{{--                    <div class="d-flex">--}}
{{--                        <div class="companies__catalog">--}}
{{--                            <div class="d-flex flex-column">--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										A--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Acura</a></li>--}}
{{--                                        <li><a href="#">Alfa romeo</a></li>--}}
{{--                                        <li><a href="#">Audi</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										B--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Bentley</a></li>--}}
{{--                                        <li><a href="#">BMW</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										C--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Cadillac</a></li>--}}
{{--                                        <li><a href="#">Chevrolet</a></li>--}}
{{--                                        <li><a href="#">Chrysler</a></li>--}}
{{--                                        <li><a href="#">Citroën</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										D--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Daewoo</a></li>--}}
{{--                                        <li><a href="#">Dodge</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										F--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Fiat</a></li>--}}
{{--                                        <li><a href="#">Ford</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										G--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Gaz</a></li>--}}
{{--                                        <li><a href="#">Geely</a></li>--}}
{{--                                        <li><a href="#">Great wall</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex flex-column">--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										H--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Honda</a></li>--}}
{{--                                        <li><a href="#">Hummer</a></li>--}}
{{--                                        <li><a href="#">Hyundai</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										I--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Infiniti</a></li>--}}
{{--                                        <li><a href="#">Isuzu</a></li>--}}
{{--                                        <li><a href="#">Iveco</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										J--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Jaguar</a></li>--}}
{{--                                        <li><a href="#">Jeep</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block active">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										K--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Kia</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										L--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Lada</a></li>--}}
{{--                                        <li><a href="#">Land rover</a></li>--}}
{{--                                        <li><a href="#">Lexus</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										M--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Mazda</a></li>--}}
{{--                                        <li><a href="#">Mercedes-benz</a></li>--}}
{{--                                        <li><a href="#">Mini</a></li>--}}
{{--                                        <li><a href="#">Mitsubishi</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex flex-column">--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										N--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Nissan</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										O--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Opel</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										P--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Peugeot</a></li>--}}
{{--                                        <li><a href="#">Porsche</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										R--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Renault</a></li>--}}
{{--                                        <li><a href="#">Rover</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										S--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Saab</a></li>--}}
{{--                                        <li><a href="#">Seat</a></li>--}}
{{--                                        <li><a href="#">Skoda</a></li>--}}
{{--                                        <li><a href="#">Smart</a></li>--}}
{{--                                        <li><a href="#">Ssangyong</a></li>--}}
{{--                                        <li><a href="#">Subaru</a></li>--}}
{{--                                        <li><a href="#">Suzuki</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										T--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Toyota</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="companies__catalog-block">--}}
{{--									<span class="companies__catalog-letter">--}}
{{--										V--}}
{{--									</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Volvo</a></li>--}}
{{--                                        <li><a href="#">Vw</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a href="#" class="companies__catalog-show"><span>Показать все</span></a>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex flex-column">--}}
{{--                            <div class="companies__block">--}}
{{--                                <h3><span>Нужна консультация?</span></h3>--}}
{{--                                <p>Оставьте нам ваш VIN-код или фото с винкодом, наш консультант поможет выбрать подходящие запчасти.</p>--}}
{{--                                <form class="companies__block-form">--}}
{{--                                    <div class="d-flex align-items-center">--}}
{{--                                        <div class="d-flex align-items-center companies__block-form-line mt0">--}}
{{--                                            <img src="/img/frontend/img/svg/id.svg" alt="telephone" class="icon companies__block-icon">--}}
{{--                                            <input type="text" placeholder="VIN код">--}}
{{--                                        </div>--}}
{{--                                        <span class="companies__block-form-or">или</span>--}}
{{--                                        <button class="pl35">--}}
{{--                                            <span><img src="/img/frontend/img/svg/upload-to-arrow.svg" alt="upload-to-arrow"></span>--}}
{{--                                            фото техпаспорта--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex align-items-center companies__block-form-line">--}}
{{--                                        <img src="/img/frontend/img/svg/mobile-phone.svg" alt="telephone" class="icon companies__block-icon">--}}
{{--                                        <input type="tel" placeholder="Номер телефона">--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex align-items-center companies__block-form-line">--}}
{{--                                        <img src="/img/frontend/img/svg/telephone3.svg" alt="telephone" class="icon companies__block-icon">--}}
{{--                                        <div class="companies__block-form-contacts">--}}
{{--                                            <!-- <input type="text" placeholder="Удобный способ связи"> -->--}}
{{--                                            <span>Удобный способ связи</span>--}}
{{--                                            <img src="/img/frontend/img/triangle.png" alt="triangle" class="arrow">--}}
{{--                                            <div class="companies__block-form-contacts-dropdown">--}}
{{--                                                <div>--}}
{{--                                                    <img src="/img/frontend/img/svg/telephone3.svg" alt="telephone">--}}
{{--                                                    <span>Телефон</span>--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <img src="/img/frontend/img/svg/viber.svg" alt="viber">--}}
{{--                                                    <span>Viber</span>--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <img src="/img/frontend/img/svg/whatsapp.svg" alt="whatsapp">--}}
{{--                                                    <span>WhatsApp</span>--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <img src="/img/frontend/img/svg/telegram_logo.svg" alt="telegram">--}}
{{--                                                    <span>Telegram</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <button type="submit" class="companies__block-form-submit">--}}
{{--                                        Отправить запрос--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                            <div class="companies__block">--}}
{{--                                <h3><span>Зарегистрируйтесь</span> на Partfix и вы сможете:</h3>--}}
{{--                                <ul>--}}
{{--                                    <li>--}}
{{--                                        <img src="/img/frontend/img/svg/car.svg" alt="car">--}}
{{--                                        <span>Сохранить ваши автомобили в «гараж» и находить их быстрее</span>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <img src="/img/frontend/img/svg/money.svg" alt="money">--}}
{{--                                        <span>Накапливать бонусы за покупки</span>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <img src="/img/frontend/img/svg/refresh.svg" alt="refresh">--}}
{{--                                        <span>Повторять заказы из вашей истории</span>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <img src="/img/frontend/img/svg/notification.svg" alt="notification">--}}
{{--                                        <span>Получать уведомления об акциях и спецпредложениях</span>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                                <form class="d-flex align-items-center companies__block-contact">--}}
{{--                                    <input type="tel" placeholder="+38 (0__) ___-___-___" required>--}}
{{--                                    <button type="submit">Зарегистрироваться</button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <section class="manufacturers">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="default-title">
                        Популярные производители
                    </h2>
                    <div class="manufacturers__slider">
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                        <div class="manufacturers__slide">
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                            <div><a href="#"><img src="img/frontend/img/kyb.png" alt="kyb"></a></div>
                        </div>
                    </div>
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
{{--        @if($garage)--}}
{{--            <div class="row">--}}
{{--                <garage--}}
{{--                    :garage="{{ $garage }}"--}}
{{--                    :current_auto="'{{ json_encode($current_auto) }}'"--}}
{{--                ></garage>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            <select-car :auto_brands="{{ json_encode($brands) }}"--}}
{{--                        :routes="'{{ json_encode($routes) }}'"--}}
{{--            ></select-car>--}}
{{--        </div>--}}
{{--        <h3>Категории</h3>--}}
{{--        @include('frontend.product-categories.categories.index', ['categories', $categories])--}}
{{--    </div>--}}
@endsection
