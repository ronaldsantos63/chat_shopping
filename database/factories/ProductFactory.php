<?php

use Faker\Generator as Faker;

$factory->define(\ChatShopping\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'description' => $faker->text(400),
        'price' => $faker->randomFloat(2, 100, 1000)
    ];
});
