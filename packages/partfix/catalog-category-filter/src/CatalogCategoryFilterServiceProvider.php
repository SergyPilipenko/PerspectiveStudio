<?php

namespace Partfix\CatalogCategoryFilter;

use Illuminate\Support\ServiceProvider;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;

class CatalogCategoryFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'partfix\catalog-category-filter');
        $this->app->singleton(CategoryFilterInterface::class, CategoryFilter::class);

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
