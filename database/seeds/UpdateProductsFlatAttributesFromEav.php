<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Catalog\Attributes\Attribute;
use Illuminate\Support\Facades\DB;

class UpdateProductsFlatAttributesFromEav extends Seeder
{
    private $limit = 50000;
    private $data = [];
    /**
     * Run the database seeds.
     *
     * @param null $offset
     * @return void
     */
    public function run($offset = null)
    {
        $attributes = Attribute::where('is_filterable', true)->get();

        foreach ($attributes as $attribute) {
            $field = \App\Models\Admin\Catalog\Product\ProductAttributeValue::$attributeTypeFields[$attribute->type];
//            echo $attribute->code . "\n";
            echo $field . "\n";
            $sql = "update products_flat pf
                    inner join product_attribute_values pv on pf.id = pv.product_id
                    set pf.{$attribute->code} = pv.{$field}
                    WHERE pv.attribute_id = {$attribute->id}
                    ";
            DB::connection()->update($sql);
        }
    }
}
