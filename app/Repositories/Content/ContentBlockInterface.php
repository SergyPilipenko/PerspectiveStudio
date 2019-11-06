<?php


namespace App\Repositories\Content;


use Illuminate\Http\Request;

interface ContentBlockInterface
{
    public function save(Request $request, $block = null);
}
