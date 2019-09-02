<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Admin\Catalog\Attributes\Attribute;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attribute::query()->delete();

        $now = Carbon::now();

        Attribute::insert([
            [
                'id' => '1',
                'code' => 'article',
                'title' => 'Артикул',
                'type' => 'text',
                'validation' => NULL,
                'position' => '1',
                'is_required' => '1',
                'is_unique' => '1',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '2',
                'code' => 'name',
                'title' => 'Название',
                'type' => 'text',
                'validation' => NULL,
                'position' => '2',
                'is_required' => '1',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '3',
                'code' => 'slug',
                'title' => 'URL',
                'type' => 'text',
                'validation' => NULL,
                'position' => '3',
                'is_required' => '1',
                'is_unique' => '1',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '4',
                'code' => 'isNew',
                'title' => 'Новый',
                'type' => 'boolean',
                'validation' => NULL,
                'position' => '4',
                'is_required' => '0',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '5',
                'code' => 'status',
                'title' => 'Статус',
                'type' => 'boolean',
                'validation' => NULL,
                'position' => '5',
                'is_required' => '1',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '6',
                'code' => 'short_description',
                'title' => 'Краткое описание',
                'type' => 'textarea',
                'validation' => NULL,
                'position' => '6',
                'is_required' => '1',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '7',
                'code' => 'description',
                'title' => 'Описание',
                'type' => 'textarea',
                'validation' => NULL,
                'position' => '7',
                'is_required' => '1',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '8',
                'code' => 'price',
                'title' => 'Цена',
                'type' => 'decimal',
                'validation' => NULL,
                'position' => '8',
                'is_required' => '1',
                'is_unique' => '0',
                'is_filterable' => '1',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '9',
                'code' => 'cost',
                'title' => 'Себестоимость',
                'type' => 'price',
                'validation' => NULL,
                'position' => '9',
                'is_required' => '0',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '10',
                'code' => 'meta_title',
                'title' => 'Meta title',
                'type' => 'textarea',
                'validation' => NULL,
                'position' => '10',
                'is_required' => '0',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '11',
                'code' => 'meta_keywords',
                'title' => 'Meta keywords',
                'type' => 'textarea',
                'validation' => NULL,
                'position' => '11',
                'is_required' => '0',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '12',
                'code' => 'meta_description',
                'title' => 'Meta description',
                'type' => 'textarea',
                'validation' => NULL,
                'position' => '12',
                'is_required' => '0',
                'is_unique' => '0',
                'is_filterable' => '0',
                'is_user_defined' => '0',
                'is_visible_on_front' => '0',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
