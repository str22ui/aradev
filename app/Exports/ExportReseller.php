<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Reseller;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportReseller implements FromView
{
    protected $reseller;

    public function __construct($reseller)
    {
        $this->reseller = $reseller;
    }

    public function view(): View
    {
        return view('admin.reseller.tableReseller', ['reseller' => $this->reseller]);
    }
}
