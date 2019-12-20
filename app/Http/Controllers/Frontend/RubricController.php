<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Content\Rubric\Rubric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Partfix\ViewedProducts\Contracts\ViewedProductsInterface;

class RubricController extends Controller
{
    private $rubric;
    /**
     * @var ViewedProductsInterface
     */
    private $viewedProducts;

    public function __construct(Rubric $rubric, ViewedProductsInterface $viewedProducts)
    {
        $this->rubric = $rubric;
        $this->viewedProducts = $viewedProducts;
    }

    public function index($slug)
    {
        $rubric = $this->rubric->where('slug', $slug)->with('groups.categories')->firstOrFail();
        $meta_tags = [
            'rubric_title' => $rubric->title
        ];
        $activeCar = app('App\Classes\Garage')->getGarage()->activeCar ?? null;
        $viewedProducts = $this->viewedProducts->getViewedProducts();

        return view('frontend.rubrics.index', compact('rubric', 'meta_tags', 'activeCar', 'viewedProducts'));
    }
}
