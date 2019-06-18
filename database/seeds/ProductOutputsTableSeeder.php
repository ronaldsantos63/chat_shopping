<?php

use ChatShopping\Models\Product;
use ChatShopping\Models\ProductOutput;
use Illuminate\Database\Seeder;

class ProductOutputsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        factory(ProductOutput::class, 150)
            ->make()
            ->each(function(ProductOutput $output) use ($products){
                $output->product_id = $products->random()->id;
                $output->save();
            });
    }
}
