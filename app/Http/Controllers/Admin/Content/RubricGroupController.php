<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Content\Rubric\Rubric;
use App\Models\Content\Rubric\RubricGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RubricGroupController extends Controller
{
    private $rubricGroup;
    /**
     * @var Rubric
     */
    private $rubric;

    public function __construct(RubricGroup $rubricGroup, Rubric $rubric)
    {
        $this->middleware('auth:admin');
        $this->rubricGroup = $rubricGroup;
        $this->rubric = $rubric;
    }

    public function create($rubricId)
    {
        return view('admin.content.rubrics.groups.create', compact('rubricId'));
    }

    public function store(Request $request, $rubricId)
    {
        $this->validate($request, array(
            'title' => 'required',
            'position' => 'required|numeric|min:0'
        ));

        $rubric =  $this->rubric->findOrFail($rubricId);
        $this->rubricGroup->title = $request->title;
        $this->rubricGroup->rubric_id = $rubricId;
        $this->rubricGroup->position = $request->position;
        $this->rubricGroup->save();

        Session::flash('flash', 'Группа была создана успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }

    public function edit($rubricId, $groupId)
    {
        $rubric = $this->rubric->findOrFail($rubricId);
        $group = $this->rubricGroup->findOrFail($groupId);

        return view('admin.content.rubrics.groups.edit', compact('rubric', 'group'));
    }

    public function update(Request $request, $rubricId, $groupId)
    {
        $rubric = $this->rubric->findOrFail($rubricId);
        $group = $this->rubricGroup->findOrFail($groupId);
        $group->title = $request->title;
        $group->rubric_id = $rubricId;
        $group->position = $request->position;
        $group->update();

        Session::flash('flash', 'Группа была обновлена успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }

    public function destroy($rubricId, $groupId)
    {
        $rubric = $this->rubric->findOrFail($rubricId);
        $group = $this->rubricGroup->findOrFail($groupId);

        $this->rubricGroup->destroy($group->id);

        Session::flash('flash', 'Группа была удалена успешно');

        return redirect()->route('admin.content.rubrics.edit', $rubric->id);
    }
}
