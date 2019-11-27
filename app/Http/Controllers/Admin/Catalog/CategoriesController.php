<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Requests\RequestInterface;
use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Catalog\Category;
use App\Models\Catalog\CategoryInterface;
use App\Models\Categories\CategoryDistinctPassangerCarTree;
use App\Models\Tecdoc\DistinctPassangerCarTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Session;
use App\Helpers\Locale;

class CategoriesController extends Controller
{
    /**
     * @var Category
     */
    private $category;
    private $locale;

    public function __construct(Category $category)
    {
        $this->middleware('auth:admin');
        $this->category = $category;

        $this->locale = app()->getLocale();
        App::singleton('App\Http\Requests\RequestInterface', 'App\Http\Requests\ProductCategoryRequest');

    }

    /**
     * Создание категории
     *
     * @param null $id
     * @param CategoryInterface $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id = null)
    {
        $categories = Category::get()->toTree();

        $store = $id ? route('admin.catalog.categories.store-subcategory', $this->category->findOrFail($id)->id) : route('admin.catalog.categories.store');
        $categoryTypes = json_encode($this->category->categoryTypes, true);

        return view('admin.catalog.categories.create', compact('store', 'categories', 'categoryTypes'));
    }

    /**
     * Запись новой категории
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $id = null)
    {
        if($id) {
            $category = $this->category->findOrFail($id);
        } else {
            $category = $this->category;
        }
        $loc = config('app.fallback_locale');

        $this->validate($request, array(
            $loc.'.category_title' => 'required|max:255|min:2',
            $loc.'.slug' => 'required|unique:catalog_categories,slug|max:255|min:2',
        ));

        if($category->exists) {
            $parent = $category;
            $category = new Category();
        }

        $category->setTranslation('category_title', $this->locale, $request->$loc['category_title']);
        $category->setTranslation('slug', $this->locale, $request->$loc['slug']);

        $category->activity = $request->category_activity ? 1 : 0;
        if($request->type != 'default' && in_array($request->type, $this->category->categoryTypes)) {
            $category->type = $request->type;
        }

        isset($parent) && $parent->exists ? $category->appendToNode($parent)->save() : $category->save();

        Session::flash('flash', 'Новая категория добавлена успешно');

        return redirect()->route('admin.catalog.categories.edit', $category->id);
    }

    /**
     * Редактирование категории
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->category->findOrFail($id);

        $categories = Category::orderBy('position', 'asc')->with('filterableAttributes')->get()->toTree();
        $filterableAttributes = Attribute::where('is_filterable', true)->get();
        $vars = [
            'category' => $category,
            'categories' => $categories,
            'filterableAttributes' => $filterableAttributes
        ];

        if($category->type == 'tecdoc') {
            $tec_doc_categories = DistinctPassangerCarTree::get();
            $category_distinct_tecdoc_categories = CategoryDistinctPassangerCarTree::where('category_id', $id)->pluck('distinct_pct_id');
            $disabled_distinct_tecdoc_categories = CategoryDistinctPassangerCarTree::where('category_id', '!=', $id)->pluck('distinct_pct_id');

            foreach ($tec_doc_categories as &$tec_doc_category) {
                if(in_array($tec_doc_category->id, $category_distinct_tecdoc_categories->toArray())) {
                    $tec_doc_category->checked = true;
                }
            }

            $tec_doc_categories = $this->prepareNodes($tec_doc_categories, $disabled_distinct_tecdoc_categories)->toTree();

            $category_distinct_tecdoc_categories = $category_distinct_tecdoc_categories->toJson();
            $vars['tec_doc_categories'] = $tec_doc_categories;
            $vars['category_distinct_tecdoc_categories'] = $category_distinct_tecdoc_categories;
            $vars['disabled_distinct_tecdoc_categories'] = $disabled_distinct_tecdoc_categories;
        }
//        compact('category', 'categories', 'tec_doc_categories', 'category_distinct_tecdoc_categories', 'disabled_distinct_tecdoc_categories', 'filterableAttributes')
        return view('admin.catalog.categories.edit', $vars);
    }

    /**
     * Обновление категории
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(RequestInterface $request, $id)
    {
        $category = $this->category->findOrFail($id);

        $category->updateCategory($request);

        Session::flash('flash', 'Новые данные сохранены успешно');

        return redirect()->route('admin.catalog.categories.edit', $category->id);
    }

    /**
     * Удаление категории
     *
     * @param $id
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Category $category)
    {
        $category->destroy($id);

        Session::flash('flash', 'Категория была удалена успешно');

        return redirect()->route('admin.catalog.categories.create');
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
