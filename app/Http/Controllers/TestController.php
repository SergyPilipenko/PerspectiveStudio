<?php

namespace App\Http\Controllers;

use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Search\Indexers\CategoriesIndexer;
use App\Search\Searchers\CategoriesSearcher;
use App\Search\Searchers\ProductsSearcher;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

/***
 * Class TestController
 *
 * Помойка, чисто для экспериментов
 *
 */

class TestController extends Controller
{
    private $elastic;

    public function __construct(ClientBuilder $elastic)
    {
        $this->middleware('auth:admin');
        $this->elastic = $elastic->create()->setHosts(config('elasticsearch.connections.default.hosts'))->build();
    }

    public function index()
    {

    }

    public function elastic(CategoriesSearcher $categoriesSearcher)
    {
        dd($categoriesSearcher->search('шины'));
        die;
    }

    public function spa()
    {
        return view('spa');
    }
}
