<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Catalog\Category;
use App\Models\Content\Rubric\Rubric;
use App\Models\Content\Rubric\RubricGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $rubric->show_in_menu = $request->show_in_menu ? true : false;
        $rubric->save();

        Session::flash('flash', 'Рубрика была создана успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }

    public function edit($id)
    {
        $rubric = Rubric::with(['groups.categories' => function($query) {
            $query->orderBy('position', 'ASC');
        }])->findOrFail($id);
        $categories = Category::orderBy('id', 'ASC')->get()->toTree();

        return view('admin.content.rubrics.edit', compact('rubric', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rubric = Rubric::with('groups')->findOrFail($id);
        $rubric->position = $request->position;
        $rubric->slug = $request->slug;
        $rubric->title = $request->title;
        $rubric->description = $request->description;
        $rubric->show_in_menu = $request->show_in_menu ? true : false;
        try {
            DB::connection()->getPdo()->beginTransaction();
            $rubric->save();
            foreach ($rubric->groups as $group) {
                $checked =
                    isset($request->categories) &&
                    isset($request->categories[$group->id]) &&
                    count($request->categories[$group->id]) ? array_keys($request->categories[$group->id]) : [];
                $group->categories()->sync($checked);
            }
            DB::connection()->getPdo()->commit();
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            Session::flash('error', $e);
            return back();
        }

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
