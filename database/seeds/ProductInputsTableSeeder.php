<?php

use ChatShopping\Models\Product;
use ChatShopping\Models\ProductInput;
use Illuminate\Database\Seeder;

class ProductInputsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        factory(ProductInput::class, 150)
            ->make()
            ->each(function (ProductInput $input) use ($products){
                $input->product_id = $products->random()->id;
                $input->save();
            });
    }
}
