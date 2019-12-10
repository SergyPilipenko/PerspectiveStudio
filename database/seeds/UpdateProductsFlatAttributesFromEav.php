<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Catalog\Attributes\Attribute;

class UpdateProductsFlatAttributesFromEav extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = Attribute::where('is_filterable', true)->get();
        dd($attributes);
        DB::table('products_flat')->orderBy('id')->select('id')->chunk(16666, function($products) use ($attributes)
        {
            $data = [];
            foreach ($attributes as $attribute) {
                $data[$attribute->code] = $this->faker->firstName;
            }
            DB::table('products_flat')->whereIn('id', $products->pluck('id'))->update($data);
        });

    }
}
