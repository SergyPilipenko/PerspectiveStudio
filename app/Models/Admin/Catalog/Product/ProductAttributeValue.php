<?php

namespace App\Models\Admin\Catalog\Product;

use App\Models\Admin\Catalog\Attributes\Attribute;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    public static $ignoreAttributes = [
        'article'
    ];
    protected $fillable = [
        'product_id',
        'attribute_id',
        'channel_id',
        'locale',
        'channel',
        'text_value',
        'boolean_value',
        'integer_value',
        'float_value',
        'datetime_value',
        'date_value',
        'json_value',
        'decimal_value'
    ];

    /**
     * @var array
     */
    public static $attributeTypeFields = [
        'text' => 'text_value',
        'textarea' => 'text_value',
        'price' => 'float_value',
        'decimal' => 'decimal_value',
        'boolean' => 'boolean_value',
        'select' => 'integer_value',
        'multiselect' => 'text_value',
        'datetime' => 'datetime_value',
        'date' => 'date_value',
        'file' => 'text_value',
        'image' => 'text_value',
    ];

    /**
     * @var Attribute
     */
    private $attributeInstance;

    public function createProductValue(array $data)
    {

        if (isset($data['attribute_id'])) {
            $attribute = Attribute::find($data['attribute_id']);
        } else {
            $attribute = Attribute::where('code', $data['attribute_code'])->first();
        }
        if (! $attribute) return;


        $data[self::$attributeTypeFields[$attribute->type]] = $data['value'];

        return $this->create($data);
    }
}
