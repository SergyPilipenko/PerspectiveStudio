<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Content\Rubric\Rubric;
use App\Models\Content\Rubric\RubricGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RubricGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create($rubricId)
    {

        return view('admin.content.rubrics.groups.create', compact('rubricId'));
    }

    public function store(Request $request, $rubricId, RubricGroup $group)
    {
        $this->validate($request, array(
            'title' => 'required',
            'position' => 'required|numeric|min:0'
        ));

        $rubric = Rubric::findOrFail($rubricId);

        $group->title = $request->title;
        $group->rubric_id = $rubricId;
        $group->position = $request->position;
        $group->save();

        Session::flash('flash', 'Группа была создана успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }

    public function edit($rubricId, $groupId)
    {
        $rubric = Rubric::findOrFail($rubricId);
        $group = RubricGroup::findOrFail($groupId);

        return view('admin.content.rubrics.groups.edit', compact('rubric', 'group'));
    }

    public function destroy($rubricId, $groupId)
    {
        $rubric = Rubric::findOrFail($rubricId);
        $group = RubricGroup::findOrFail($groupId);

        RubricGroup::destroy($group->id);

        Session::flash('flash', 'Группа была удалена успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }
}
