<?php

namespace App\Models\Admin\Import;

use Illuminate\Database\Eloquent\Model;

class ImportSetting extends Model
{
    public $with = ['importable'];

    public function importable()
    {
        return $this->morphTo();
    }
}
