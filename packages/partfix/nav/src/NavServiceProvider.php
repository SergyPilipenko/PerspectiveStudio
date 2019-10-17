<?php

namespace Partfix\Nav;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Partfix\CategoriesAdapter\App\CategoriesAdapter;
use Partfix\CategoriesAdapter\App\CategoriesAdapterInterface;
use Partfix\Nav\App\Nav;
use Partfix\Nav\App\NavInterface;

class NavServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->loadViewsFrom(__DIR__.'/views', 'partfix\nav');
        App::singleton(NavInterface::class, Nav::class);

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
