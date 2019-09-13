<accordian>
    <div slot="header">Остатки</div>
    <div slot="body">
        <div class="col-md-4">
            <div class="form-group">
                <label for="quantity">Остаток</label>
                <input type="number"
                       min="0"
                       id="quantity"
                       name="quantity"
                       value="{{ old('quantity') ?: $product->quantity }}"
                       class="form-control {{ ValidationHelper::errorExists($errors, 'quantity') ? 'error' : '' }}">
                @include('admin.partials.input-errors', ['input_name' => 'quantity'])
            </div>
        </div>
    </div>
</accordian>
