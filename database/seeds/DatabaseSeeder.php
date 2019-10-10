<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
//             DistinctPassangerCarTree::class,
//             ImportColumnSeeder::class,
//             AutoTypes::class,
//             AddManufacturersSlug::class,
//             AddModelsSlug::class,
//             AddModelsConstructionIntervalTable::class,
//             AttributeFamilyTableSeeder::class,
//             AttributeGroupTableSeeder::class,
//             AttributeGroupTableSeeder::class,
             RenameVWtoVOLKSWAGEN::class,
             CreateProductsFromTecdocArticles::class,
             UpdateTecdocProductsAttributes::class
         ]);
    }
}
