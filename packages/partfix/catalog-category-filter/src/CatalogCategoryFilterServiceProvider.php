<?php

namespace Partfix\CatalogCategoryFilter;

use Illuminate\Support\ServiceProvider;
use Partfix\CatalogCategoryFilter\Contracts\CategoryFilterInterface;
use Partfix\CatalogCategoryFilter\Model\CategoryFilter;

class CatalogCategoryFilterServiceProvider extends ServiceProvider
{
    protected $namespace = 'Partfix\CatalogCategoryFilter\Http\Controllers';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
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

    }
}
