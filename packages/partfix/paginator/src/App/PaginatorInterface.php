<?php


namespace Partfix\Paginator\App;
use Illuminate\Pagination\Paginator as IlluminatePaginator;


interface PaginatorInterface
{
    public function paginate($items, $perPage, $currentPage = null, array $options = []) : IlluminatePaginator;
}
