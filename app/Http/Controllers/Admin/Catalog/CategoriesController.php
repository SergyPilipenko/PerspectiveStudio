<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Models\Categories\Category;
use App\Models\Tecdoc\DistinctPassangerCarTree;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.catalog.categories.index');
    }

    public function create($category = null)
    {
        $categories = Category::get()->toTree();

        if($category) $category = Category::findOrFail($category);

        return view('admin.catalog.categories.create', compact('categories', 'category'));
    }

    public function store(Request $request, $parent_category = null)
    {
        $this->validate($request, [
            'category_title' => 'required|min:3',
        ]);

        $category = new Category;
        $category->title = $request->category_title;
        $category->activity = $request->category_activity ? true : false;

        $parent_category ? $category->appendToNode(Category::findOrFail($parent_category))->save() : $category->save();

        Session::flash('flash', 'Новая категория добавлена успешно');

        return redirect()->route('admin.categories.edit', $category);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::get()->toTree();
        $tec_doc_categories = DistinctPassangerCarTree::get()->toTree();

        return view('admin.catalog.categories.edit', compact('category', 'categories', 'tec_doc_categories'));
    }

    public function update(Request $request, Category $category)
    {
        dd($request);
        $this->validate($request, [
            'category_title' => 'required|min:3',
        ]);

        $category->title = $request->category_title;
        $category->activity = $request->category_activity ? true : false;
        $category->update();

        Session::flash('flash', 'Новые данные сохранены успешно');

        return redirect()->route('admin.categories.edit', $category);
    }

    public function destroy($id)
    {
        Category::whereId($id)->delete();
        Session::flash('flash', 'Категория была удалена успешно');

        return redirect()->route('admin.categories.create');
    }
}
