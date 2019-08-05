<?php

use App\Models\Admin\Import\ImportColumn;
/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(ImportColumn::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'code' => $faker->unique()->word,
    ];
});
