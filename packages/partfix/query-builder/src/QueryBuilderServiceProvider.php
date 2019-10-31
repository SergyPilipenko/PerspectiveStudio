<?php

namespace Partfix\QueryBuilder;

use Illuminate\Support\ServiceProvider;
use Partfix\QueryBuilder\Model\MysqlQueryBuilder;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;

class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SQLQueryBuilder::class, MysqlQueryBuilder::class);
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
