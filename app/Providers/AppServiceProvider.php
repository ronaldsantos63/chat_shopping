<?php

namespace ChatShopping\Providers;

use ChatShopping\Models\ProductInput;
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
