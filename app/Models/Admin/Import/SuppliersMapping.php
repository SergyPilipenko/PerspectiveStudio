<?php

namespace App\Models\Admin\Import;

use App\Models\Tecdoc\Supplier;
use Illuminate\Database\Eloquent\Model;

class SuppliersMapping extends Model
{

    protected $with = ['supplier'];

    public function supplier()
    {

        return $this->hasOne(Supplier::class, 'id', 'supplier_id');

    }

    public function create(array $data)
    {
        $new_mapping = new self();
        $new_mapping->supplier_id = $data['supplier_id'];
        $new_mapping->title = $data['supplier'];
        if ($new_mapping->save()) return $new_mapping;
    }
}
