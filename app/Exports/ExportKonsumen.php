<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Konsumen;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportKonsumen implements FromView
{
    protected $konsumen;

    public function __construct($konsumen)
    {
        $this->konsumen = $konsumen;
    }

    public function view(): View
    {
        return view('admin.konsumen.tableKonsumen', ['konsumen' => $this->konsumen]);
    }
}
