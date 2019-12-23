<?php

namespace App\Http\Controllers\Admin\Tecdoc;

use App\Models\Tecdoc\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierCountryController extends Controller
{
    /**
     * @var Supplier
     */
    private $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function index()
    {
        $suppliers = $this->supplier->paginate(20);

        return view('admin.tecdoc.suppliers-countries.index', compact('suppliers'));
    }
}
