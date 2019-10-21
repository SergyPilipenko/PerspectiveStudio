<?php


namespace App\Filters;


class MainFilter
{
    public $filterBlocks = [];

    public function renderFilterOptions($entity, $filterableAttributes)
    {

        foreach ($entity as $item)
        {

            foreach ($filterableAttributes as $key => $filterableAttribute)
            {
                $attrCode = $filterableAttribute->code;
                if(!isset($this->filterBlocks[$key]) || !in_array($item->$attrCode, $this->filterBlocks[$key])) {
                    $this->filterBlocks[$key]['id'] = $filterableAttribute->id;
                    $this->filterBlocks[$key]['type'] = $filterableAttribute->type;
                    $this->filterBlocks[$key]['title'] = $filterableAttribute->title;
                    $this->filterBlocks[$key]['code'] = $filterableAttribute->code;
                    $this->filterBlocks[$key]['items'][$item->$attrCode][] = $item;

                }
            }
        }
        dd($this->filterBlocks);
        dd(1);
    }
}
