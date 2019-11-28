<?php

namespace Partfix\SiteMap;

use Illuminate\Support\ServiceProvider;
use Partfix\SiteMap\model\SiteMaper;


class SiteMapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SiteMaper::class);

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
