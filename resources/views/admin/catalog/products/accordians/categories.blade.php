<accordian>
    <div slot="header">Категории</div>
    <div slot="body">
        <div class="col-md-4">
{{--            {{ dd($categories->toJson()) }}--}}
            <product-categories
                :product_categories="{{ $categories->toJson() }}"
                :selected_categories="'{{ $product->categories }}'"
                :locale="'{{ config('app.fallback_locale') }}'"
            ></product-categories>
        </div>
    </div>
</accordian>
