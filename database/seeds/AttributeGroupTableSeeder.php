<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Catalog\Attributes\AttributeGroup;
use App\Models\Admin\Catalog\Attributes\AttributeGroupMapping;

class AttributeGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttributeGroup::query()->delete();

        AttributeGroup::insert([
            [
                'id' => '1',
                'name' => 'Общее',
                'position' => '1',
                'is_user_defined' => '0',
                'attribute_family_id' => '1'
            ],

            [
                'id' => '2',
                'name' => 'Описание',
                'position' => '2',
                'is_user_defined' => '0',
                'attribute_family_id' => '1'
            ],

            [
                'id' => '3',
                'name' => 'Seo',
                'position' => '3',
                'is_user_defined' => '0',
                'attribute_family_id' => '1'
            ],

            [
                'id' => '4',
                'name' => 'Прайс',
                'position' => '4',
                'is_user_defined' => '0',
                'attribute_family_id' => '1'
            ],

            [
                'id' => '5',
                'name' => 'Характеристики',
                'position' => '5',
                'is_user_defined' => '0',
                'attribute_family_id' => '1'
            ]
        ]);
        AttributeGroupMapping::query()->delete();

        AttributeGroupMapping::insert([
            ['attribute_id' => '1','attribute_group_id' => '1','position' => '1'],
            ['attribute_id' => '2','attribute_group_id' => '1','position' => '2'],
            ['attribute_id' => '3','attribute_group_id' => '1','position' => '3'],
            ['attribute_id' => '4','attribute_group_id' => '1','position' => '4'],
            ['attribute_id' => '5','attribute_group_id' => '1','position' => '5'],
            ['attribute_id' => '6','attribute_group_id' => '2','position' => '6'],
            ['attribute_id' => '7','attribute_group_id' => '2','position' => '7'],
            ['attribute_id' => '8','attribute_group_id' => '4','position' => '8'],
            ['attribute_id' => '9','attribute_group_id' => '4','position' => '9'],
            ['attribute_id' => '10','attribute_group_id' => '3','position' => '10'],
            ['attribute_id' => '11','attribute_group_id' => '3','position' => '11'],
            ['attribute_id' => '12','attribute_group_id' => '3','position' => '12'],

        ]);
    }
}
