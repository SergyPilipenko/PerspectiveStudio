<?php

namespace Partfix\MetaTags;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Partfix\CategoriesAdapter\App\CategoriesAdapter;
use Partfix\CategoriesAdapter\App\CategoriesAdapterInterface;
use Partfix\MetaTags\Contracts\MetaTagsInterface;
use Partfix\MetaTags\Model\MetaTags;
use Partfix\Nav\App\Nav;
use Partfix\Nav\App\NavInterface;

class MetaTagsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MetaTagsInterface::class, MetaTags::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'meta-tags');
    }
}
