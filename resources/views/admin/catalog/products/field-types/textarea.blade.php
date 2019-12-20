<div class="col-md-6">
    <div class="form-group {{ $attribute->is_required ? 'required' : '' }}">
        <label for="{{ $attribute->code }}">{{ $attribute->title }}</label>
        @if($attribute->code == 'description' || 'short_description')
        <textarea
            name="{{ $attribute->code }}"
            id="ckeditor-{{ $attribute->code }}"
            class="form-control {{ ValidationHelper::errorExists($errors, $attribute->code) ? 'error' : '' }}"
        >{{ old($attribute->code) ?: $product->getAttrValue($attribute->code) }}
        </textarea>
        @else
            <textarea
                name="{{ $attribute->code }}"
                id="{{ $attribute->code }}"
                class="form-control {{ ValidationHelper::errorExists($errors, $attribute->code) ? 'error' : '' }}"
                >{{ old($attribute->code) ?: $product->getAttrValue($attribute->code) }}
            </textarea>
        @endif
        @include('admin.partials.input-errors', ['input_name' => $attribute->code])
    </div>

</div>
