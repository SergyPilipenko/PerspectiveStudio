<?php


namespace Partfix\Paginator\App;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Pagination\Paginator as IlluminatePaginator;

class Paginator implements PaginatorInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Paginator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a new IlluminatePaginator instance.
     *
     * @param  mixed  $items
     * @param  int  $perPage
     * @param  int|null  $currentPage
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage, $currentPage = null) : LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            array_slice($items, $currentPage, $perPage),
            count($items),
            $perPage,
            $currentPage,
            array(
            'path' => $this->request->getPathInfo(),
            'pageName' => 'page'
            )
        );
    }
}
