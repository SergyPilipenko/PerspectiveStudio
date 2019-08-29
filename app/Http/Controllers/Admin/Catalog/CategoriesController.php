<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Models\Catalog\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Создание категории
     *
     * @param Category|null $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Category $category = null)
    {
        $categories = Category::get()->toTree();
        $store = $category ? route('admin.catalog.categories.store-subcategory', $category) : route('admin.catalog.categories.store');

        return view('admin.catalog.categories.create', compact('category', 'store', 'categories'));
    }

    /**
     * Запись новой категории
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Category $category)
    {
        $this->validate($request, array(
            'category_title' => 'required|max:255|min:2',
            'slug' => 'required|unique:catalog_categories|max:255|min:2',
        ));

        if($category->exists) {
            $parent = $category;
            $category = new Category();
        }

        $category->category_title = $request->category_title;
        $category->slug = $request->slug;
        $category->activity = $request->category_activity ? true : false;

        isset($parent) && $parent->exists ? $category->appendToNode($parent)->save() : $category->save();

        Session::flash('flash', 'Новая категория добавлена успешно');

        return redirect()->route('admin.catalog.categories.edit', $category);
    }

    /**
     * Редактирование категории
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $categories = Category::orderBy('position', 'asc')->get()->toTree();

        return view('admin.catalog.categories.edit', compact('category', 'categories'));
    }

    /**
     * Обновление категории
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, array(
            'category_title' => 'required|max:255|min:2',
            'slug' => 'required|max:255|min:2|unique:catalog_categories,slug,'.$category->id,
        ));

        $category->category_title = $request->category_title;
        $category->slug = $request->slug;
        $category->activity = $request->category_activity ? true : false;
        $category->position = $request->position;
        $category->update();

        Session::flash('flash', 'Новые данные сохранены успешно');

        return redirect()->route('admin.catalog.categories.edit', $category);
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
