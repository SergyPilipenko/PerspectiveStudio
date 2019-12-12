<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Content\Rubric\Rubric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RubricController extends Controller
{
    private $rubric;

    public function __construct(Rubric $rubric)
    {
        $this->rubric = $rubric;
    }

    public function index($slug)
    {
        $rubric = $this->rubric->where('slug', $slug)->with('groups.categories')->firstOrFail();

        return view('frontend.rubrics.index', compact('rubric'));
    }
}
