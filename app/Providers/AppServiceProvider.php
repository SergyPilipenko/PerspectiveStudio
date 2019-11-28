<?php

namespace App\Providers;

use App\Classes\Car\Car;
use App\Classes\Car\CarInterface;
use App\Classes\Garage;
use App\Models\Catalog\Category;
use App\Models\Catalog\CategoryInterface;
use App\Models\Locale\Locale;
use App\Models\Locale\LocaleInterface;
use App\Repositories\Content\ContentBlock;
use App\Repositories\Content\ContentBlockInterface;
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
        $this->app->singleton('App\Repositories\Product\ProductRepositoryInterface', 'App\Repositories\Product\ProductRepository');
        $this->app->singleton('App\Repositories\Cart\CartRepositoryInterface', 'App\Repositories\Cart\CartRepository');
        $this->app->singleton('App\Repositories\Cart\CartItemRepositoryInterface', 'App\Repositories\Cart\CartItemRepository');
        $this->app->singleton('App\Repositories\Order\OrderItemRepositoryInterface', 'App\Repositories\Order\OrderItemRepository');
        $this->app->singleton('App\Models\Order\OrderItemInterface', 'App\Models\Order\OrderItem');
        $this->app->singleton('App\Models\Cart\CartInterface', 'App\Models\Cart\Cart');
        $this->app->singleton('App\Models\Cart\CartItemInterface', 'App\Models\Cart\CartItem');
        $this->app->singleton('App\Models\Admin\Catalog\Product\ProductInterface', 'App\Models\Admin\Catalog\Product\Product');
        $this->app->singleton('App\Http\Requests\RequestInterface', 'App\Http\Requests\CartRequest');
        $this->app->singleton('App\Repositories\Order\OrderRepositoryInterface', 'App\Repositories\Order\OrderRepository');
        $this->app->singleton('App\Models\Order\OrderInterface', 'App\Models\Order\Order');
        $this->app->singleton(CategoryInterface::class, Category::class);
        $this->app->singleton(PriceFilterInterface::class, PriceFilter::class);
        $this->app->singleton(LocaleInterface::class, Locale::class);
        $this->app->singleton(CarInterface::class, Car::class);
        $this->app->singleton(ContentBlockInterface::class, ContentBlock::class);
        $this->app->singleton(Garage::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if(!env('APP_DEBUG')) {
            \Debugbar::disable();
        }



        $this->app->singleton('PartfixTecDoc', function () {
            return new \App\Classes\PartfixTecDoc;
        });

    }
}
