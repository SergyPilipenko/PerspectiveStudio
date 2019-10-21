<?php


namespace Partfix\Paginator\App;
use Illuminate\Pagination\Paginator as IlluminatePaginator;

class Paginator implements PaginatorInterface
{
    /**
     * Create a new IlluminatePaginator instance.
     *
     * @param  mixed  $items
     * @param  int  $perPage
     * @param  int|null  $currentPage
     * @param  array  $options (path, query, fragment, pageName)
     * @return IlluminatePaginator
     */
    public function paginate($items, $perPage, $currentPage = null, array $options = []) : IlluminatePaginator
    {
        return $paginator =  new IlluminatePaginator($items, $perPage, $currentPage, $options);
    }
}
