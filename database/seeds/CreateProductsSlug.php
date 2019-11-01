<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductsSlug extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::connection()->select("
        select pv.text_value, p.id from products p
        LEFT JOIN product_attribute_values pv on p.id = pv.product_id
        JOIN attributes a on pv.attribute_id = a.id
        WHERE a.code = 'name'
        ");

        $update = [];
        foreach ($products as $product) {

        }
    }
}
