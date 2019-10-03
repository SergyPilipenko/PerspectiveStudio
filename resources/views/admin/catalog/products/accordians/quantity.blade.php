<accordian>
    <div slot="header">Остатки</div>
    <div slot="body">
        <div class="form-check">
            <div class="col-md-12">
                        <span>
                            Превышение лимита остатков
                        </span>
                <label class="switch">
                    <input type="checkbox"
                           @if(old('checked') || $product->depends_quantity == true)
                               checked="checked"
                           @endif
                           name="depends_quantity">
                    <span class="slider round">
                            </span>
                    <i class="input-helper"></i>
                </label>
            </div>
        </div>
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
