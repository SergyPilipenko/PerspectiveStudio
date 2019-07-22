<?php

namespace App\Models\Admin\Import;

use App\Models\Prices\Price;
use Illuminate\Database\Eloquent\Model;

class ImportSetting extends Model
{
    public $with = ['importable'];

//    protected $appends = ['pricesCount'];

    public $timestamps = true;
    public $columns;

    public function importable()
    {
        return $this->morphTo();
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function getPricesCountAttribute()
    {
        return $this->prices->count();
    }

    public function importErrors()
    {
        return $this->hasMany(InvalidPrice::class);
    }

    public function getImportErrorsCountAttribute()
    {
        return $this->importErrors->count();
    }

    public function scopeParse($query, $id) : ImportSetting
    {

        $import_setting = $query->find($id);
        $columns = ImportColumn::all();

        if($import_setting && $columns) {
            $scheme = json_decode($import_setting->scheme);
            foreach ($columns as $column) {
                $import_setting->columns[$column->code] = $import_setting->getColumnChar($scheme, $column);
            }
        }

        return $import_setting;
    }

    protected function getColumnChar(array $scheme, ImportColumn $column) : string
    {

        if($scheme && $column) {
            foreach ($scheme as $item) {
                if(!empty($item->value) && $item->value == $column->id) return $item->column;
            }
        }
    }

}
