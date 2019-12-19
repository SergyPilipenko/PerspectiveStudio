<?php

namespace Partfix\ViewedProducts;

use Illuminate\Support\ServiceProvider;
use Partfix\ViewedProducts\Contracts\ViewedProductsInterface;
use Partfix\ViewedProducts\model\ViewedProducts;

class ViewedProductsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'partfix\viewed-products');
        $this->app->singleton(ViewedProductsInterface::class, ViewedProducts::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
