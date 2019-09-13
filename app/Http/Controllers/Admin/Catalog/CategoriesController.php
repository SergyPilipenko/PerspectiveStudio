<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Requests\RequestInterface;
use App\Models\Catalog\Category;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id = null)
    {
        $categories = Category::get()->toTree();

        $store = $id ? route('admin.catalog.categories.store-subcategory', $this->category->findOrFail($id)->id) : route('admin.catalog.categories.store');

        return view('admin.catalog.categories.create', compact('category', 'store', 'categories'));
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
        $category->activity = $request->category_activity ? true : false;

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

        $categories = Category::orderBy('position', 'asc')->get()->toTree();

        return view('admin.catalog.categories.edit', compact('category', 'categories'));
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
}
