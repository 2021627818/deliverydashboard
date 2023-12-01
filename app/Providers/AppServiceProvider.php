<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    Blade::component('x-customer-layout', \App\View\Components\CustomerLayout::class);
    Blade::component('x-courier-layout', \App\View\Components\CourierLayout::class);
}
}
