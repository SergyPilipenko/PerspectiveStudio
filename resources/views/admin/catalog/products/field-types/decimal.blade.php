<div class="col-md-4">
    <div class="form-group {{ $attribute->is_required ? 'required' : '' }}">
        <label for="{{ $attribute->code }}">{{ $attribute->title }}</label>
        <input type="number"
               step="0.01" min="0"
               id="{{ $attribute->code }}"
               name="{{ $attribute->code }}"
               value="{{ old($attribute->code) ?: $product[$attribute->code] }}"
               class="form-control {{ ValidationHelper::errorExists($errors, $attribute->code) ? 'error' : '' }}">
        @include('admin.partials.input-errors', ['input_name' => $attribute->code])
    </div>
</div>
