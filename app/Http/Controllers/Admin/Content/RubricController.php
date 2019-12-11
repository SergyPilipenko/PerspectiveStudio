<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Catalog\Category;
use App\Models\Content\Rubric\Rubric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RubricController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $rubrics = Rubric::orderBy('id', 'desc')->paginate(20);

        return view('admin.content.rubrics.index', compact('rubrics'));
    }

    public function create()
    {
        return view('admin.content.rubrics.create');
    }

    public function store(Request $request, Rubric $rubric)
    {
        $this->validate($request, array(
            'position' => 'required|numeric:min:0',
            'slug' => 'required|unique:rubrics,slug,'.$request->slug,
            'title' => 'required'
        ));

        $rubric->position = $request->position;
        $rubric->slug = $request->slug;
        $rubric->title = $request->title;
        $rubric->description = $request->description;
        $rubric->save();

        Session::flash('flash', 'Рубрика была создана успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }

    public function edit($id)
    {
        $rubric = Rubric::with(['groups' => function($query) {
            $query->orderBy('position', 'ASC');
        }])->findOrFail($id);
        $categories = Category::orderBy('id', 'ASC')->get();

        return view('admin.content.rubrics.edit', compact('rubric', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rubric = Rubric::findOrFail($id);
        $rubric->position = $request->position;
        $rubric->slug = $request->slug;
        $rubric->title = $request->title;
        $rubric->description = $request->description;
        $rubric->save();

        Session::flash('flash', 'Рубрика была обновлена успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }

    public function destroy($id)
    {
        Rubric::destroy($id);

        Session::flash('flash', 'Рубрика была удалена успешно');

        return redirect()->route('admin.content.rubrics.index');
    }
}
