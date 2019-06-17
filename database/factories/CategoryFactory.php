<?php

use Faker\Generator as Faker;

$factory->define(ChatShopping\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName
    ];
});
