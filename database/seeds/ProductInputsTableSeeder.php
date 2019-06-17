<?php

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
        factory(ProductInput::class, 10)->create();
    }
}
