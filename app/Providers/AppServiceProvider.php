<?php

namespace App\Providers;

use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
