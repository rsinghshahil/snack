<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Flavour;
use Faker\Generator as Faker;

$factory->define(Flavour::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'cost' => $faker->numberBetween($min = 10, $max = 100),
        'status' => intval($faker->boolean),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
    ];
});
