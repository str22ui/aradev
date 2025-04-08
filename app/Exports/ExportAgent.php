<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Agent;
use App\Models\Perumahan;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportAgent implements FromView
{
    protected $agents;

    public function __construct($agents)
    {
        $this->agents = $agents;
    }

    public function view(): View
    {
        $perumahan = Perumahan::all();
        return view('admin.agent.tableAgent', ['agents' => $this->agents, 'perumahan' => $perumahan]);
    }
}
