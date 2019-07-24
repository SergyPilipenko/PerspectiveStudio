<?php

namespace App\Models\Admin\Import;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportByUrl extends Model
{

    public function setting()
    {
        return $this->morphOne(ImportSetting::class, 'importable');
    }

    public static function import($request)
    {
//        $url = "http://root:123456@atr.orap.de/1562941049UTRpricelist%20(copy).csv";
        $url = preg_replace('/ /', '%20', $request->url);

        $filecontent = file_get_contents($url);

        $tmpfname = tempnam(sys_get_temp_dir(),"tmpxls");

        file_put_contents($tmpfname,$filecontent);

        return IOFactory::load($tmpfname)->getActiveSheet()->toArray();

    }


    public static function create($request)
    {

        $ImportByUrl = new self();
        $ImportByUrl->link = $request->link;
        $ImportByUrl->update_periods = $request->updatePeriod;
        if ($ImportByUrl->save()) return $ImportByUrl;

    }
}
