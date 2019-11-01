<?php


namespace Partfix\Paginator\App;
use Illuminate\Pagination\LengthAwarePaginator;


interface PaginatorInterface
{
    public function paginate($items, $perPage, $currentPage = null) : LengthAwarePaginator;
}
