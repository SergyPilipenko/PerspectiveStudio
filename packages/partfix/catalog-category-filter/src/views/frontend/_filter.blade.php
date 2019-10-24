<div class="subcategory__sidebar">
    <catalog-filter inline-template :filter_qty_action="'{{ route('catalog.category.filter.filterqty') }}'" category_id="{{ $category->id }}" :category_link="'{{ route('frontend.product-categories.show', $category->slug) }}'">
        <div class="filter-blocks-container">
            @foreach ($filter->items as $filterBlock)
                @include('partfix\catalog-category-filter::frontend.block-types.'.$filterBlock->attribute->type, ['filterBlock' => $filterBlock])
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
