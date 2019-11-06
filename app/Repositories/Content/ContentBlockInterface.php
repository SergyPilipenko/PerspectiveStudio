<?php


namespace App\Repositories\Content;


use App\Models\Content\Block\Block;
use Illuminate\Http\Request;

interface ContentBlockInterface
{
    public function save(Request $request, Block $block = null)  : void;
    public function render(string $identifier) : string;
    public function getModel() : Block;
}
