<?php

namespace Partfix\Paginator;

use Illuminate\Support\ServiceProvider;
use Partfix\Paginator\App\Paginator;
use Partfix\Paginator\App\PaginatorInterface;

class PaginatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaginatorInterface::class, Paginator::class);
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
