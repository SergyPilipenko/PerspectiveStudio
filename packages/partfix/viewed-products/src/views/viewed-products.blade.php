@if($viewedProducts)
    <div class="last-goods__slider">
        @foreach($viewedProducts as $viewedProduct)
            <div class="last-goods__slide">
                <a href="{{ route('frontend.product.show', $viewedProduct->slug) }}"><img src="{{ $viewedProduct->images->first() != null && file_exists($viewedProduct->images->first()->path) ? asset($viewedProduct->images->first()->path) : asset('img/frontend/img/images-empty.png') }}" alt="last-good" class="last-goods__image"></a>
                <div class="d-flex flex-column"><a href="#"><span class="last-goods__title">{{ $viewedProduct->manufacturer }}</span></a><a href="#"><span class="last-goods__type">{{ $viewedProduct->title }}</span></a></div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                        <span class="last-goods__price">{{ $viewedProduct->price }} грн</span>
                        <div class="d-flex align-items-center last-goods__available">
                            <img src="/img/frontend/img/svg/delivery-truck-green.svg" alt="truck">
                            <span>В наличии</span>
                        </div>
                    </div>
                    <add-to-cart
                        product="{{ $viewedProduct }}"
                        action="{{ route('frontend.cart.add', $viewedProduct->id) }}">
                        <div slot="button">
                            <button class="last-goods__buy">Купить</button>
                        </div>
                    </add-to-cart>
                </div>
            </div>
        @endforeach
    </div>
@endif
