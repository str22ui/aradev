<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Penawaran;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPenawaran implements FromView
{
    protected $penawaran;

    public function __construct($penawaran)
    {
        $this->penawaran = $penawaran;
    }

    public function view(): View
    {
        return view('admin.penawaran.tablePenawaran', ['penawaran' => $this->penawaran]);
    }
}
