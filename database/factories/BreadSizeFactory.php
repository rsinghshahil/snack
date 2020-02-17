<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BreadSize;
use Faker\Generator as Faker;

$factory->define(BreadSize::class, function (Faker $faker) {
    return [
        'size' => $faker->numberBetween($min = 15, $max = 30),
        'cost' => $faker->numberBetween($min = 10, $max = 100),
        'status' => intval($faker->boolean),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
    ];
});
