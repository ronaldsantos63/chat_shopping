<?php

use ChatShopping\Models\ProductInput;
use Faker\Generator as Faker;

$factory->define(ChatShopping\Models\ProductInput::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(1, 20)
    ];
});

//$factory->afterCreating(ProductInput::class, function ($input, $faker){
//    $product = $input->product;
//    $product->stock += $input->amount;
//    $product->save();
//});
