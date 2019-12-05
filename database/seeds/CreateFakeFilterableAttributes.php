<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CreateFakeFilterableAttributes extends Seeder
{
    /**
     * @var Faker
     */
    private $faker;

    /**
     * CreateFakeFilterableAttributes constructor.
     * @param Faker $faker
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$attributes = factory(\App\Models\Admin\Catalog\Attributes\Attribute::class, 200)->create();
	
	DB::connection('mysql')->insert('INSERT INTO products_flat (id, article, type, parent_id, attribute_family_id, created_at, updated_at, quantity, depends_quantity, manufacturer) SELECT * FROM products');
	$attributes = \App\Models\Admin\Catalog\Attributes\Attribute::where('id', '>', 13)->get();
        DB::table('products_flat')->orderBy('id')->select('id')->chunk(16666, function($products) use ($attributes)
        {
            $data = [];
            foreach ($attributes as $attribute) {
                $data[$attribute->code] = $this->faker->firstName;
            }
            DB::table('products_flat')->whereIn('id', $products->pluck('id'))->update($data);
        });

//        foreach ($attributes as $attribute) {
//
//        }
    }
}
