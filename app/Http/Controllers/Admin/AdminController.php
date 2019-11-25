<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function ckeditorUploadImage(Request $request)
    {
        $base_path = 'img/upload/ckeditor-images/';
        $file = $request->file('upload');
        $file_name = time() . $file->getClientOriginalName();
        $file->move($base_path, $file_name);
        $response = array(
            'uploaded' => true,
            'fileName' => $file_name,
            'url' => '/'.$base_path.$file_name
        );

        return $response;
    }

    public function gotest()
    {
        return 3;
    }
}
