<?php

namespace App\Repositories\Content;

use App\Models\Content\Block\Block;
use Illuminate\Http\Request;

class ContentBlock implements ContentBlockInterface
{
    private $block;

    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function save(Request $request, $block = null)
    {
        if($block) {
            $this->update($request, $block);
        } else {
            $this->create($request);
        }
    }

    public function getModel()
    {
        return $this->block;
    }

    private function prepareData($request)
    {
        $data = $request->only($this->block->getFillable());
        $data['content'] = $request->ckeditor;
        if(isset($data['enabled'])) $data['enabled'] = true;

        return $data;
    }

    public function render($identifier)
    {
        $block = $this->block->where('identifier', $identifier)->first();

        return $block->content;
    }

    private function create($request)
    {
        $data = $this->prepareData($request);

        $this->block->create($data);
    }

    private function update($request, $block)
    {
        $data = $this->prepareData($request);

        $block->update($data);
    }
}
