<?php

namespace App\Models\Prices;

use App\Models\Admin\Import\ImportSetting;
use Illuminate\Database\Eloquent\Model;

class UploadHistory extends Model
{
    protected $with = ['import_setting'];

    public function import_setting()
    {
        return $this->hasOne(ImportSetting::class, 'id', 'import_setting_id');
    }
}
