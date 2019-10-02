<?php

namespace App\Http\Controllers\Admin\Locale;

use App\Models\Locale\LocaleInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function index(LocaleInterface $locale)
    {
        $locales = $locale->orderBy('id', 'desc')->paginate(15);

        return view('admin.settings.locales.index', compact('locales'));
    }

    public function create()
    {
        return view('admin.settings.locales.create');
    }

    public function store(Request $request, LocaleInterface $locale)
    {
        $this->validate($request, array(
            'code' => 'required|unique:locales,code',
            'name' => 'required'
        ));

        $locale->create($request->toArray());

        Session::flash('flash', 'Новые данные были сохранены успешно');

        return redirect()->route('admin.settings.locales.index');
    }

    public function edit($id, LocaleInterface $locale)
    {
        $locale = $locale->findOrFail($id);

        return view('admin.settings.locales.edit', compact('locale'));
    }

    public function update(Request $request, $id, LocaleInterface $locale)
    {
        $this->validate($request, array(
            'name' => 'required'
        ));

        $locale = $locale->findOrFail($id);
        $locale->name = $request->name;
        $locale->update();

        Session::flash('flash', 'Новые данные были сохранены успешно');

        return redirect()->route('admin.settings.locales.index');
    }
}
