<?php

namespace Partfix\CategoriesAdapter;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Partfix\CategoriesAdapter\App\CategoriesAdapter;
use Partfix\CategoriesAdapter\App\CategoriesAdapterInterface;
use Partfix\Nav\App\Nav;
use Partfix\Nav\App\NavInterface;

class CategoriesAdapterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::singleton(CategoriesAdapterInterface::class, CategoriesAdapter::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
