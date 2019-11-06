<?php

namespace App\Http\Controllers\Admin\Content;

use App\Repositories\Content\ContentBlockInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\DB;

class BlockController extends Controller
{
    private $contentBock;
    private $redirect;
    private $sessionManager;

    public function __construct(
        ContentBlockInterface $contentBock,
        Redirector $redirect,
        SessionManager $sessionManager
    )
    {
        $this->contentBock = $contentBock;
        $this->redirect = $redirect;
        $this->sessionManager = $sessionManager;
    }

    public function index()
    {
        $blocks = $this->contentBock->getModel()->orderBy('id', 'desc')->paginate(20);

        return view('admin.content.blocks.index', compact('blocks'));
    }

    public function create()
    {
        return view('admin.content.blocks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required',
            'identifier' => 'required|unique:content_blocks,identifier'
        ));

        $this->contentBock->save($request);

        $this->sessionManager->flash('flash', 'Новый блок был создан успешно');

        return $this->redirect->route('admin.content.blocks.index');
    }

    public function edit($id)
    {
        $block = $this->contentBock->getModel()->findOrFail($id);

        return view('admin.content.blocks.edit', compact('block'));
    }

    public function update(Request $request, $id)
    {
        $block = $this->contentBock->getModel()->findOrFail($id);

        $this->contentBock->save($request, $block);

        $this->sessionManager->flash('flash', 'Новые данные были сохранены успешно');

        return $this->redirect->route('admin.content.blocks.edit', $id);
    }

    public function destroy($id)
    {
        $this->contentBock->getModel()->findOrFail($id)->delete();

        $this->sessionManager->flash('flash', 'Блок был удален успешно');

        return $this->redirect->route('admin.content.blocks.index');
    }
}
