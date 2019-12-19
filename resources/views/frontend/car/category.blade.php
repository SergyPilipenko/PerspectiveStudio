@section('meta_title', $category->meta_title ?: app('MetaTags')->getMetaTag('meta-tags::meta.frontend-car-category.title', [
'brand' => $car->brand->description,
'model' => $car->model->description,
'modification' => $car->modification->description,
'year' => $car->year,
'category_title' => $category->category_title
]))
@section('meta_description', $category->meta_description ?: app('MetaTags')->getMetaTag('meta-tags::meta.frontend-car-category.description'))
@section('meta_keywords', $category->meta_keywords ?: app('MetaTags')->getMetaTag('meta-tags::meta.frontend-car-category.keywords'))
@extends('frontend')
@section('content')
    <section class="card">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! Breadcrumbs::render('frontend.car.category', $category, $car, $brand, $model, $modification) !!}
                </div>
            </div>
        </div>
    </section>
    <div class="subcategory__title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1>{{ $category->alias ?: $category->category_title }} для <span>{{ $car->brand->description }} {{ $car->model->description }} {{ $car->formatCapacity($car->Capacity) }}</span></h1>
                        <?php $routes = ['get-brands-by-models-created-year' => route('api.get-brands-by-models-created-year')] ?>
                        <choose-car-button
                            :garage="'{{ json_encode(app('App\Classes\Garage')->getGarage()) }}'"
                            :auto_brands="{{ json_encode(app('App\Classes\Garage')->getCheckedBrands()) }}"
                            :routes="'{{ json_encode($routes) }}'"
                        ></choose-car-button>
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
                        @if($products->count())
                            @include('partfix\catalog-category-filter::frontend._filter', ['filter' => $category->getFilter($car), 'category' => $category, 'car' => $car, 'categoryLink' => $categoryLink])
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
                                    <button><img src="/img/frontend/img/card-view.png" alt="card-view" class="card-view"></button>
                                    <button><img src="/img/frontend/img/list-view.png" alt="list-view"></button>
                                </div>
                            </div>
                            <div class="subcategory__main">
                            @foreach($products as $product)
                                    @if($product->productCanBeDisplayed())
                                        <div class="subcategory__cell">
                                            <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                <div class="subcategory__img">
                                                    <img src="{{ $product->images->first() != null && file_exists($product->images->first()->path) ? asset($product->images->first()->path) : asset('img/frontend/img/images-empty.png') }}" alt="photo">
                                                </div>
                                            </a>
                                            <span class="subcategory__code">Код: {{ $product->article }} </span>
                                                <span class="subcategory__company">{{ $product->manufacturer }}</span>
                                                <span class="subcategory__type">{{ $product->name }}</span>
                                                <div class="d-flex align-items-end"><span class="subcategory__price">{{ $product->price }}<sup>грн</sup></span>
                                                    @if($product->old_price)
                                                        <span class="subcategory__price subcategory__price--old">
                                                            <span>{{ $product->old_price }}</span>
                                                            <sup>грн</sup>
                                                        </span>
                                                    @endif
                                                </div>
{{--                                                <p class="subcategory__sale">Вернем <span>1226 грн</span></p>--}}
                                                <div class="subcategory__cell subcategory__cell--overlay">
                                                    <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                        <div class="subcategory__img">
                                                            <img src="{{ $product->images->first() != null && file_exists($product->images->first()->path) ? asset($product->images->first()->path) : asset('img/frontend/img/images-empty.png') }}" alt="photo">
                                                        </div>
                                                    </a>
                                                    <span class="subcategory__code">Код: {{ $product->article }} </span>
                                                    <span class="subcategory__company">{{ $product->manufacturer }}</span>
                                                    <span class="subcategory__type">{{ $product->name }}</span>
                                                    <div class="d-flex align-items-end"><span class="subcategory__price">{{ $product->price }}<sup>грн</sup></span>
                                                        @if($product->old_price)
                                                            <span class="subcategory__price subcategory__price--old">
                                                                <span>{{ $product->old_price }}</span><sup>грн</sup>
                                                            </span>
                                                        @endif
                                                    </div>
{{--                                                    <p class="subcategory__sale">Вернем <span>1226 грн</span></p>--}}
                                                    <div class="subcategory__buy">
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
                                                </div>
                                        </div>
                                    @else
                                        <div class="subcategory__cell subcategory__cell--na">
                                            <a href="{{ route('frontend.product.show', $product->slug) }}">
                                                <div class="subcategory__img">
                                                    <img src="{{ $product->image }}" alt="photo">
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
{{--                            <div class="subcategory__more">--}}
{{--                                <button>--}}
{{--                                    <div><img src="/img/frontend/img/svg/refresh2.svg" alt="refresh"></div>--}}
{{--                                    <span>загрузить еще 21 товар</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        </div>
                        @else
                            <p>Ничего не найдено...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <section class="subcategory__links">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <ul>--}}
{{--                        <li>--}}
{{--                            <a href="#">Ссылка разовая</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Тормозные диск</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Колодки для буса</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Торможение 18</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Свежетормоз</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Коврик для торможения</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Дичайшее ПП</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Органический бочёк</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    @if($category->description)
    <section class="subcategory__info">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! $category->description !!}
                </div>
            </div>
        </div>
    </section>
    @endif
    @if($viewedProducts)
        <section class="last-goods pb30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="default-title">
                            последние просмотренные товары
                        </h2>
                        @include('partfix\viewed-products::viewed-products', ['viewedProducts' => $viewedProducts])
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include('frontend.partials._advatages')
@endsection
