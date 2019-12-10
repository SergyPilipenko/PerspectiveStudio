<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Catalog\Attributes\Attribute;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

/** Добавляет filterable поля в таблицу $flat_table */
class AddFilterableAttributesToFlatTableWithEavData extends Seeder
{
    /**
     * @var Attribute
     */
    private $attribute;
    private $flat_table = 'products_flat';
    private $typeScheme = [
        'text' => 'text',
        'boolean' => 'boolean',
        'decimal' => 'decimal',
        'textarea' => 'longText'
        ];


    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function run()
    {
        $filterableAttributes = $this->attribute->where('is_filterable', true)->get();

        DB::table('products_flat')->orderBy('id')->select('id')->chunk(16666, function($products) use ($filterableAttributes)
        {
            $data = [];
            $typeScheme = $this->typeScheme;

            foreach ($filterableAttributes as $attribute) {
                try {
                    Schema::table($this->flat_table, function (Blueprint $table) use ($typeScheme, $attribute, $products) {
                        $type = $typeScheme[$attribute->type];
                        $table->$type($attribute->code)->nullable();
                        $table->index($attribute->code);
                    });
                } catch (\PDOException $exception) {
                    continue;
                }
            }
        });
    }
}
