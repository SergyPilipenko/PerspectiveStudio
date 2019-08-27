<?php

use Illuminate\Database\Seeder;
use App\Models\AutoType;

class AutoTypes extends Seeder
{
    private $types = [
        'cars' => 'Легковые',
        'trucks' => 'Грузовые',
        'motobikes' => 'Мотоциклы'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::connection()->getPdo()->beginTransaction();

            foreach ($this->types as $key => $type) {
                AutoType::updateOrCreate(['code' => $key], [
                    'title' => $type,
                    'code' => $key
                ]);
            }

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
    }
}
