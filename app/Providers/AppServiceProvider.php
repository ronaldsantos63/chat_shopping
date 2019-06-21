<?php

namespace ChatShopping\Providers;

use ChatShopping\Models\ProductInput;
use ChatShopping\Models\ProductOutput;
use ChatShopping\Models\ProductPhoto;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);

        ProductInput::created(function (ProductInput $input){
            $product = $input->product;
            $product->stock += $input->amount;
            $product->save();

            //Estudar sobre Observers e Events Eloquent pela doc do laravel
        });

        ProductOutput::created(function (ProductOutput $output){
            $product = $output->product;
            $product->stock -= $output->amount;
            if ($product->stock < 0) {
                throw new \Exception("Estoque de {$product->name} não pode ser negativo!");
            }
            $product->save();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
