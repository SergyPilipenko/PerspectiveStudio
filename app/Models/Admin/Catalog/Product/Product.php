<?php

namespace App\Models\Admin\Catalog\Product;

use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['type', 'attribute_family_id', 'article', 'parent_id'];

    /**
     * @var ProductAttributeValue instance
     */
    private $productAttributeValue;


    public function __construct()
    {
        $this->productAttributeValue = new ProductAttributeValue;
    }


    public function attribute_family()
    {
        return $this->belongsTo(AttributeFamily::class);
    }

    public function super_attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_super_attributes');
    }

    public function productUpdate(array $request, int $id)
    {
        $product = $this->findOrFail($id);
        $product->update($request);

        $attributes = $product->attribute_family->custom_attributes()->get();

        foreach ($attributes as $attribute) {

            if (!isset($request[$attribute->code]) || (in_array($attribute->type, ['date', 'datetime']) && !$request[$attribute->code]))
                continue;
//            dd(213);

            $attributeValue = $this->productAttributeValue->where([
                'product_id' => $product->id,
                'attribute_id' => $attribute->id
            ])->first();

            if (!$attributeValue) {
                $this->productAttributeValue->createProductValue([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'value' => $request[$attribute->code]
                ]);

//                dd($attributeValue);
            }
        }
        dd('success');
    }
}
