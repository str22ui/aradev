<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportReport implements FromView
{
    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function view(): View
    {
        return view('admin.report.tableReport', ['report' => $this->report]);
    }
}
