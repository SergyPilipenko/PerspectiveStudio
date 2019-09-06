<?php

namespace App\Http\Requests;

use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Attributes\AttributeValue;
use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductImage;
use Illuminate\Foundation\Http\FormRequest;

class ProductForm extends FormRequest
{
    protected $rules, $attributeFamily, $product, $attributeValue, $productImage;

    public function __construct(AttributeFamily $attributeFamily, Product $product, AttributeValue $attributeValue, ProductImage $productImage)
    {
        $this->attributeFamily = $attributeFamily;
        $this->product = $product;
        $this->attributeValue = $attributeValue;
        $this->prodctImage = $productImage;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules = [
            'article' => 'required|unique:products,article,'. $this->id
        ];

        $inputs = $this->all();

        $product = $this->product->findOrFail($this->id);

        $attributes = $product->attribute_family->custom_attributes()->get();

        $productSuperAttributes = $product->super_attributes;

        foreach ($attributes as $attribute) {
            if(!$productSuperAttributes->contains($attribute)) {
                if ($attribute->code == 'article') {
                    continue;
                }
                $validations = [];

                if ($attribute->is_required) {
                    array_push($validations, 'required');
                } else {
                    array_push($validations, 'nullable');
                }

                if ($attribute->type == 'text' && $attribute->validation) {
                    array_push($validations, $attribute->validation);
                }

                $this->rules[$attribute->code] = $validations;
            }
        }
        $this->prodctImage->uploadImages($this, $product);

        return $this->rules;
    }
}
