<div class="subcategory__sidebar mobile-hide-children">
    <catalog-filter inline-template
                    :filter_qty_action="'{{ route('catalog.category.filter.filterqty') }}'"
                    category_id="{{ $category->id }}"
                    :category_link="'{{ $categoryLink }}'"
                    @if(isset($car->modification->id))
                    :modification="{{ $car->modification->id }}"
                    @endif>

        <div class="filter-blocks-container">
            <h3 class="d-sm-none">Фильтры</h3>
            <span class="close"><img src="{{ asset('img/frontend/img/cross.png') }}" alt="img"></span>
            <div class="subcategory__sidebar-block">
                <div class="d-flex justify-content-between">
                    <span class="subcategory__sidebar-chosen">Вы выбрали:</span><span class="subcategory__sidebar-cancel">Сбросить все</span>
                </div>
                <applied-filters></applied-filters>

            </div>

            @foreach ($filter->items as $filterBlock)
                @if(count($filterBlock->getOptions()))
                    @include('partfix\catalog-category-filter::frontend.block-types.'.$filterBlock->attribute->type, ['filterBlock' => $filterBlock])
                @endif
            @endforeach
            <preload-layout></preload-layout>
        </div>
    </catalog-filter>
    <button class="subcategory__sidebar-clear">
        Отменить всё
    </button>
    <div class="subcategory__sidebar-more">
        <h3>Смотрите еще</h3>
        <p><a href="#">Ссылка 1</a>, <a href="#">Ссылка первая</a>, <a href="#">Ссылка
                короткая</a>, <a href="#">Ссылка мощнейшего тока</a>, <a href="#">Ссылка
                микролинк</a>, <a href="#">Ссылка
                сталинская</a>, <a href="#">Отссылка</a>, <a href="#">Как у пацана</a>, <a href="#">Номер
                восемь</a>
        </p>
    </div>
</div>
