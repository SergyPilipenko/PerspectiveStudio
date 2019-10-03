<div class="col-md-4">
    <div class="form-group">
        <label for="{{ $attribute->code }}">{{ $attribute->title }}</label>
        <select class="form-control" id="{{ $attribute->code }}" name="{{ $attribute->code }}">

            <?php $selectedOption = old($attribute->code) ?: $product->getAttrValue($attribute->code) ?>

            <option value="0" {{ $selectedOption ? '' : 'selected'}}>
                Нет
            </option>
            <option value="1" {{ $selectedOption ? 'selected' : ''}}>
                Да
            </option>
        </select>
    </div>
</div>
