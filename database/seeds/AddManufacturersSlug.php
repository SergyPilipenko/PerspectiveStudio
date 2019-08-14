<?php

use App\Models\ManufacturersUri;
use App\Models\Tecdoc\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddManufacturersSlug extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::connection()->getPdo()->beginTransaction();

            $manufacturers = Manufacturer::where('ispassengercar', 'true')->where('canbedisplayed', 'true')->get();

            foreach ($manufacturers as $manufacturer) {
                $manufacturer_uri = new ManufacturersUri;
                $manufacturer_uri->slug = Transliterate::make(str_replace(' ', '-', mb_strtolower($manufacturer->description)));
                $manufacturer_uri->manufacturer_id = $manufacturer->id;
                $manufacturer_uri->save();
            }

            DB::connection()->getPdo()->commit();
        } catch (\PDOException $exception) {
            DB::connection()->getPdo()->rollBack();
            dd($exception);
        }
    }
}
