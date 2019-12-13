<?php

namespace App\Models\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Attribute extends Model
{

    public $inputs = [
        'type' => [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'price' => 'Price',
            'boolean' => 'Boolean',
            'select' => 'Select',
            'multiselect' => 'Multiselect',
            'datetime' => 'Datetime',
            'date' => 'Date',
            'image' => 'Image',
            'file' => 'File',
        ],
        'validation' => [
            'numeric' => 'Число',
            'email' => 'Email',
            'decimal' => 'Число с точкой',
            'url' => 'URL',
        ],
    ];
    protected static function boot()
    {
        parent::boot();
        self::creating(function($attribute) {
            $this->syncFilterableFieldWithProductsFlatTable($attribute);
        });
        self::updating(function($attribute) {
            $this->syncFilterableFieldWithProductsFlatTable($attribute);
        });
        self::deleting(function($attribute) {
            if(Schema::hasColumn('products_flat', $attribute->code)) {
                Schema::table('products_flat', function (Blueprint $table) use ($attribute) {
                    $table->dropColumn($attribute->code);
                });
            }
        });
    }
    public function scopeCustom($query)
    {
        return $query->where('is_user_defined', true);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values');
    }

    public function setProductsAttributes($products)
    {
        if($products->count()) {
            $productIds = $products->pluck('id');
            $attributes = $this->getProductsAttributes($productIds);
            if($attributes->count()) {
                $products = $this->addAttributesToProducts($products, $attributes);
            }
        }

        return $products;
    }

    public function getProductsAttributes($productsIds)
    {
        return DB::table(env('DB_DATABASE').".products as p")
            ->join(env('DB_DATABASE').".product_attribute_values as  pav", "p.id", "pav.product_id")
            ->join(env('DB_DATABASE').".attributes as  a", "pav.attribute_id", "a.id")
            ->whereIn("p.id", $productsIds)
            ->get();
    }

    private function addAttributesToProducts($products, $attributes)
    {
        $grouppedByProductId = [];

        foreach ($attributes as $item) {
            $grouppedByProductId[$item->product_id][] = $item;
        }
        foreach ($products as $product) {
            $productAttributes = $this->formatProductAttributes($grouppedByProductId[$product->id]);
            foreach ($productAttributes as $key => $attribute)
            {
                if(!$product->getAttribute($key))
                {
                    if($key == 'price') {
                        $product->$key = $product->getPrice();
                        continue;
                    }
                    $product->$key = $attribute;
                } else {
                    $product->custom_attributes = $attribute;
                }
            }
        }

        return $products;
    }

    private function formatProductAttributes($attributes)
    {
        $formatted = [];
        foreach ($attributes as $attribute) {
            if(!in_array($attribute->code, ProductAttributeValue::$ignoreAttributes)) {
                $value = ProductAttributeValue::$attributeTypeFields[$attribute->type];
                $formatted[$attribute->code] = $attribute->$value;
            }
        }

        return $formatted;
    }

    public function syncFilterableFieldWithProductsFlatTable($attribute)
    {

        if($attribute->is_filterable && !Schema::hasColumn('products_flat', $attribute->code)) {
            Schema::table('products_flat', function (Blueprint $table) use ($attribute) {
                $type = ProductAttributeValue::$schema[$attribute->type];
                $table->$type($attribute->code)->nullable();
            });
        }
        if(!$attribute->is_filterable && Schema::hasColumn('products_flat', $attribute->code)) {
            Schema::table('products_flat', function (Blueprint $table) use ($attribute) {
                $table->dropColumn($attribute->code);
            });
        }
    }
}
