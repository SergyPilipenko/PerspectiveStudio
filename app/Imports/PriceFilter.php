<?php


namespace App\Imports;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use App\Imports\ImportFilter;

class PriceFilter extends ImportFIlter implements IReadFilter
{

    public $rows;
    public $max_length;

    public function readCell($column, $row, $worksheetName = '') {
        if ($row >= 1 && $row <= 7) {
            if (in_array($column,range('A','E'))) {
                return true;
            }
        }
        return false;
    }

    public function filter($rows)
    {
        $filtered = [];


        foreach ($rows as $row) {
            if($this->countMore(3, $row)) {

                $filtered[] = $row;
            }
        }


        $this->rows = $filtered;

        return $this;
    }

    protected function countMore($count, $row)
    {
        $rowCount = 0;
        foreach ($row as $item) {
            if(!empty($item)) $rowCount++;
        }

        if($rowCount >= $count) {
            return $row;
        } else {
            return false;
        }

    }

    public function getRowsMaxLength($rows = null)
    {
        if(!$rows) $rows = $this->rows;
        $this->max_length = 0;
        foreach ($rows as $row) {
            if(count($row) > $this->max_length) $this->max_length = count($row);
        }
        return $this;
    }

    public function maxRowsCount($max_count, $rows = null)
    {
        if(!$rows) $rows = $this->rows;
        $x = 0;
        $this->rows = [];
        foreach ($rows as $row) {
            if($x >= $max_count) break;
            $this->rows[] = $row;
            $x++;
        }
        return $this;
    }

    public function getPreview($rows, $rows_count = 10)
    {
        return $this->filter($rows)
            ->maxRowsCount($rows_count)
            ->getRowsMaxLength();
    }
}
