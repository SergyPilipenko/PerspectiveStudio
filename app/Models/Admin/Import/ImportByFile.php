<?php

namespace App\Models\Admin\Import;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Import\ChunkReadFilter;

class ImportByFile extends Model
{
    public function __construct($attributes = [])
    {
//        $this->chunkReadFilter = resolve(ChunkReadFilter::class);
        parent::__construct();
    }

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

    public static function readCell($column, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row == 1 || ($row >= 20 && $row <= 30)) {
            return true;
        }
        return false;
    }

    public function file_get_contents_chunked($file,$chunk_size,$callback)
    {
        try
        {
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle))
            {
                call_user_func_array($callback,array(fread($handle,$chunk_size),&$handle,$i));
                $i++;
            }

            fclose($handle);

        }
        catch(Exception $e)
        {
            trigger_error("file_get_contents_chunked::" . $e->getMessage(),E_USER_NOTICE);
            return false;
        }

        return true;
    }

    public function test($request)
    {
        $file = $request->file('file');
//        dd($file->getClientOriginalName());
//        dd(mime_content_type('upload/prices/1575468107S Plus.csv'));
        $extension = $file->getClientOriginalExtension();
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');

        /**  Define how many rows we want to read for each "chunk"  **/
        /**  Create a new Reader of the type defined in $inputFileType  **/
//        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');

        /**  Define how many rows we want to read for each "chunk"  **/
//        $chunkSize = 50;
        /**  Create a new Instance of our Read Filter  **/
//        $chunkFilter = new ChunkReadFilter();
//        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        /**  Define how many rows we want to read for each "chunk"  **/
        $chunkSize = 65530;
        /**  Create a new Instance of our Read Filter  **/
        $chunkFilter = new ChunkReadFilter();

        /**  Tell the Reader that we want to use the Read Filter  **/
        /**    and that we want to store it in contiguous rows/columns  **/

        $reader->setReadFilter($chunkFilter)
            ->setContiguous(true);

        /**  Instantiate a new Spreadsheet object manually  **/
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        /**  Set a sheet index  **/
        $sheet = 0;
        /**  Loop to read our worksheet in "chunk size" blocks  **/
        /**  $startRow is set to 2 initially because we always read the headings in row #1  **/
        for ($startRow = 2; $startRow <= 1000000; $startRow += $chunkSize) {
            /**  Tell the Read Filter which rows we want to read this loop  **/
            $chunkFilter->setRows($startRow,$chunkSize);

            /**  Increment the worksheet index pointer for the Reader  **/
            $reader->setSheetIndex($sheet);
            /**  Load only the rows that match our filter into a new worksheet  **/
            $reader->loadIntoExisting('upload/prices/1575460609autonom_ua-84851.csv',$spreadsheet);
            /**  Set the worksheet title for the sheet that we've justloaded)  **/
            /**    and increment the sheet index as well  **/
            var_dump($spreadsheet->getActiveSheet()->setTitle('Country Data #'.(++$sheet))->toArray(null, true, true, true));
//            dump($spreadsheet);
        }
//        $sheet = 0;
//        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
//
//        /**  Tell the Reader that we want to use the Read Filter  **/
////        $reader->setReadFilter($chunkFilter);
//        $reader->setReadFilter($chunkFilter)
//            ->setContiguous(true);
//        /**  Loop to read our worksheet in "chunk size" blocks  **/
//        for ($startRow = 50; $startRow <= 200; $startRow += $chunkSize) {
//            $chunkFilter->setRows($startRow,$chunkSize);
//
//            /**  Increment the worksheet index pointer for the Reader  **/
//            $reader->setSheetIndex($sheet);
//            /**  Load only the rows that match our filter into a new worksheet  **/
//            $reader->loadIntoExisting($inputFileName,$spreadsheet);
//            /**  Set the worksheet title for the sheet that we've justloaded)  **/
//            /**    and increment the sheet index as well  **/
//            $spreadsheet->getActiveSheet()->setTitle('Country Data #'.(++$sheet));
//        }
        dd(1);
//        $csv = new \SplFileObject($file);
//        $csv->setFlags(\SplFileObject::READ_CSV);
//        $start = 0;
//        $batch = 500;
//        $result = [];
//        $x = 0;
//        while (!$csv->eof() || $x == 50) {
////            if($x >= 50) break;
//            foreach(new \LimitIterator($csv, $start, $batch) as $line){
////                if($x >= 50) break;
//                $result[] = $line;
//                $x++;
//                if($x >= 5)
//                break;
//            }
//            $start += $batch;
//            break;
//        }
        dd($result);
//        return 'success';
        return static::getRows($spreadsheet);
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
