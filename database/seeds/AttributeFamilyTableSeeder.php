<?php

use App\Models\Admin\Catalog\Attributes\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Admin\Catalog\Attributes\AttributeFamily;

class AttributeFamilyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttributeFamily::query()->delete();

        $now = Carbon::now();

        AttributeFamily::insert([
            'id' => '1',
            'code' => 'default',
            'name' => 'Стандартный',
            'status' => '0',
            'is_user_defined' => '0'
        ]);
    }
}
