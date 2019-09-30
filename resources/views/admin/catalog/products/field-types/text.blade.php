<div class="col-md-4">
    <div class="form-group {{ $attribute->is_required ? 'required' : '' }}">
        <label for="{{ $attribute->code }}">{{ $attribute->title }}</label>
{{--        {{ dd($product->getAttrValue($attribute->code)) }}--}}
    @if($attribute->code == 'short_description')
        @endif
        <input type="text"
               id="{{ $attribute->code }}"
               name="{{ $attribute->code }}"
{{--               value="{{ old($attribute->code) ?: $product[$attribute->code] }}"--}}
               value="{{ old($attribute->code) ?: $product->getAttrValue($attribute->code) }}"
               class="form-control {{ ValidationHelper::errorExists($errors, $attribute->code) ? 'error' : '' }}">
        @include('admin.partials.input-errors', ['input_name' => $attribute->code])
    </div>

</div>
