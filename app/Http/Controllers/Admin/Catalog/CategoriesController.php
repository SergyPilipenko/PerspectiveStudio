<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Models\Categories\Category;
use App\Models\Categories\CategoryDistinctPassangerCarTree;
use App\Models\Tecdoc\DistinctPassangerCarTree;
use Illuminate\Support\Facades\DB;
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
        $tec_doc_categories = DistinctPassangerCarTree::get();

//        $category_distinct_tecdoc_categories = CategoryDistinctPassangerCarTree::getCategorySelects();

        $category_distinct_tecdoc_categories = CategoryDistinctPassangerCarTree::where('category_id', $id)->pluck('distinct_pct_id');
        $disabled_distinct_tecdoc_categories = CategoryDistinctPassangerCarTree::where('category_id', '!=', $id)->pluck('distinct_pct_id');

        foreach ($tec_doc_categories as &$tec_doc_category) {
            if(in_array($tec_doc_category->id, $category_distinct_tecdoc_categories->toArray())) {
                $tec_doc_category->checked = true;
            }
        }

        $tec_doc_categories = $this->prepareNodes($tec_doc_categories, $disabled_distinct_tecdoc_categories)->toTree();

        $category_distinct_tecdoc_categories = $category_distinct_tecdoc_categories->toJson();

        return view('admin.catalog.categories.edit', compact('category', 'categories', 'tec_doc_categories', 'category_distinct_tecdoc_categories', 'disabled_distinct_tecdoc_categories'));
    }

    public function update(Request $request, $category)
    {
        $this->validate($request, [
            'category_title' => 'required|min:3',
        ]);
        $category = Category::find($category);

        try {
            DB::connection()->getPdo()->beginTransaction();

            $category->title = $request->category_title;
            $category->activity = $request->category_activity ? true : false;
            $category->update();

            $tree = null;

            if($request->tree234) {
                $tree = explode(',', $request->tree234);
                foreach ($tree as &$item) {
                    $item = (int) $item;
                }
            }

            $category->tecdoc_categories()->sync($tree);

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $e) {

            DB::connection()->getPdo()->rollBack();
            return $e->getMessage();

        }

        Session::flash('flash', 'Новые данные сохранены успешно');

        return redirect()->route('admin.categories.edit', $category);
    }

    public function destroy($id)
    {
        Category::whereId($id)->delete();

        Session::flash('flash', 'Категория была удалена успешно');

        return redirect()->route('admin.categories.create');
    }

    private function prepareNodes($nodes, $disabled_distinct_tecdoc_categories)
    {
        if($nodes) {
            foreach ($nodes as $key => &$node) {
                if(!$node) {
                    unset($nodes[$key]);
                } else {
                    $node->label = $node->description;
                    if(in_array($node->id, $disabled_distinct_tecdoc_categories->toArray())) {
                        $node->isDisabled = "true";
                    };
                    unset($node->description);
                };
            }
        }
        return $nodes;
    }
}
