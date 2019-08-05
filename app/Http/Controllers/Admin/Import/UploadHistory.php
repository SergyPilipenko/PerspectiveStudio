<?php

namespace App\Http\Controllers\Admin\Import;

use App\Models\Prices\UploadHistory as History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadHistory extends Controller
{
    public function index()
    {
        $history = History::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.upload-history.index', compact('history'));
    }
}
