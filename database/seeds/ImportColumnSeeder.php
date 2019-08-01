<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Import\ImportColumn;

class ImportColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(ImportColumn::first()) return;
        $data = [
            ['title' => 'Оригинальный номер', 'code' => 'article'],
            ['title' => 'Производитель', 'code' => 'supplier'],
            ['title' => 'Цена', 'code' => 'price'],
            ['title' => 'Наличие', 'code' => 'available'],
        ];

        ImportColumn::insert($data);
    }
}
