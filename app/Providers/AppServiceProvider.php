<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Classes\PriceFilter\PriceFilterInterface;
use App\Classes\PriceFilter\PriceFilter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::singleton('App\Repositories\Product\ProductRepositoryInterface', 'App\Repositories\Product\ProductRepository');
        App::singleton('App\Repositories\Cart\CartRepositoryInterface', 'App\Repositories\Cart\CartRepository');
        App::singleton('App\Repositories\Cart\CartItemRepositoryInterface', 'App\Repositories\Cart\CartItemRepository');
        App::singleton('App\Repositories\Order\OrderItemRepositoryInterface', 'App\Repositories\Order\OrderItemRepository');
        App::singleton('App\Models\Order\OrderItemInterface', 'App\Models\Order\OrderItem');
        App::singleton('App\Models\Cart\CartInterface', 'App\Models\Cart\Cart');
        App::singleton('App\Models\Cart\CartItemInterface', 'App\Models\Cart\CartItem');
        App::singleton('App\Models\Admin\Catalog\Product\ProductInterface', 'App\Models\Admin\Catalog\Product\Product');
        App::singleton('App\Http\Requests\RequestInterface', 'App\Http\Requests\CartRequest');
        App::singleton('App\Repositories\Order\OrderRepositoryInterface', 'App\Repositories\Order\OrderRepository');
        App::singleton('App\Models\Order\OrderInterface', 'App\Models\Order\Order');
        App::singleton('App\Models\Order\OrderInterface', 'App\Models\Order\Order');
        App::singleton(PriceFilterInterface::class, PriceFilter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Debugbar::disable();


        $this->app->singleton('PartfixTecDoc', function () {
            return new \App\Classes\PartfixTecDoc;
        });

    }
}
