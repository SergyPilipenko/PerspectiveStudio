<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Admin\Catalog\Attributes\Attribute::class, function (Faker $faker) {
    return [
        'code' => strtolower($faker->unique()->firstName),
        'title' => $faker->firstName,
        'type' => 'textarea',
        'position' => 10,
        'is_required' => 0,
        'validation' => NULL,
        'is_unique' => '0',
        'is_filterable' => '1',
        'is_user_defined' => '0',
        'is_visible_on_front' => '0',
        'created_at' => now(),
        'updated_at' => now()
    ];
});
