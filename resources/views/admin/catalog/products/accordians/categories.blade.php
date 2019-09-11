<accordian>
    <div slot="header">Категории</div>
    <div slot="body">
        <div class="col-md-4">
            <product-categories
                :product_categories="'{{ $categories }}'"
                :selected_categories="'{{ $product->categories }}'"
                :locale="'{{ config('app.fallback_locale') }}'"
            ></product-categories>
        </div>
    </div>
</accordian>