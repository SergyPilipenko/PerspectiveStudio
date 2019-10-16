<?php

namespace App\Http\Controllers\Admin\Products;

use App\Filters\ProductsFilter;
use App\Models\Prices\Price;
use App\Models\Tecdoc\Article;
use App\Models\Tecdoc\ArticleNumber;
use App\Models\Tecdoc\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\PartfixTecDoc;
use DB;

class ProductsController extends Controller
{

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(ProductsFilter $filter)
    {
        $prices = ArticleNumber::with('supplier', 'article', 'prices')->filter($filter)->paginate(10);

        return view('admin.products.index', compact('prices'));
    }

    public function edit($article, PartfixTecDoc $tec_doc)
    {
        $article = ArticleNumber::whereId($article)->with('supplier', 'article', 'prices.importSetting')->first();

        $article->crosses = $tec_doc->getArtCross($article->datasupplierarticlenumber, $article->supplierid);

        $brands = $tec_doc->getBrands();

        $suppliers = Supplier::all();

        $article->attributes = $tec_doc->getArtAttributes($article->datasupplierarticlenumber, $article->supplierid);

        return view('admin.products.edit', compact('article', 'crosses', 'suppliers', 'brands'));
    }
}
