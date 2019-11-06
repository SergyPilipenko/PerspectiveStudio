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

    public function save(Request $request, Block $block = null) : void
    {
        if($block) {
            $this->update($request, $block);
        } else {
            $this->create($request);
        }
    }

    public function getModel() : Block
    {
        return $this->block;
    }

    public function prepareData(Request $request)
    {
        $data = $request->only($this->block->getFillable());
        $data['content'] = $request->ckeditor;
        if(isset($data['enabled'])) {
            $data['enabled'] = true;
        } $data['enabled'] = false;

        return $data;
    }

    public function render(string $identifier) : string
    {
        $block = $this->block->where('identifier', $identifier)->first();

        return $block->content ?? '';
    }

    private function create(Request $request) : void
    {
        $data = $this->prepareData($request);

        $this->block->create($data);
    }

    private function update(Request $request, Block $block) : void
    {
        $data = $this->prepareData($request);

        $block->update($data);
    }
}
