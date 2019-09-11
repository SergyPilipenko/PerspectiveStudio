<?php

use Illuminate\Database\Seeder;
use App\Models\Catalog\Category;
use Illuminate\Support\Facades\DB;

class addLocalesToProductCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $categories = Category::all();
            foreach ($categories as $category) {
                if(!count($category->getTranslations()['category_title'])) {
                    $category_title = DB::connection('mysql')->selectOne("
                    SELECT `category_title` FROM `catalog_categories`
                        WHERE `id` = {$category->id}"
                    );

                    $category->setTranslation('category_title', 'ru', $category_title->category_title);
                };
                if(!count($category->getTranslations()['slug'])) {
                    $category_slug = DB::connection('mysql')->selectOne("
                    SELECT `slug` FROM `catalog_categories`
                        WHERE `id` = {$category->id}"
                    );

                    $category->setTranslation('slug', 'ru', $category_slug->slug);
                };
                $category->update();
            }
            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
    }
}
