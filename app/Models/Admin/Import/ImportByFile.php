<?php

namespace App\Models\Admin\Import;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Session;

class ImportByFile extends Model
{
    public function setting()
    {
        return $this->morphOne(ImportSetting::class, 'importable');
    }

    public function image()
    {
        return $this->morphOne(ImportSetting::class, 'importable');
    }

    protected static $formats = ['xls', 'xlsx', 'csv'];

    /**
     * @param $file
     * @return string
     */
    protected static function saveFile($file): string
    {
        $file_name = time() . $file->getClientOriginalName();

        $file_path = 'upload/prices/';

        if ($file->move($file_path, $file_name)) {
            $path = $file_path . $file_name;
            Session::put('file_path', $path);
        };

        return $path;
    }


    public static function import($request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if(!in_array($extension, self::$formats)) {
            $error_msg = 'Неправильный формат файла';
            Session::flash('error', $error_msg);
            abort(415, $error_msg);
        }

        $path = self::saveFile($file);

        $spreadsheet = IOFactory::load($path);

        return static::getRows($spreadsheet);

    }

    public static function create($request)
    {

        $ImportByFile = new self();
        $ImportByFile->file = Session::get('file_path');
        if($ImportByFile->save()) return $ImportByFile;

    }

    /**
     * @param array $spreadsheets
     * @return array
     */
    public static function unpackSpreadSheets(array $spreadsheets) : array
    {
        $rows = [];
        foreach ($spreadsheets as $spreadsheet) {
            foreach ($spreadsheet as $item) {
                $rows[] = $item;
            }
        }

        return $rows;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getRows(Spreadsheet $spreadsheet) : array
    {
        $sheets = [];

        $sheetCount = $spreadsheet->getSheetCount();

        for ($i = 0; $i < $sheetCount; $i++) {
            $sheet = $spreadsheet->getActiveSheet($i);
            $sheetData = $sheet->toArray(null, true, true, true);
            $sheets[] = $sheetData;
        }

        return static::unpackSpreadSheets($sheets);
    }
}
