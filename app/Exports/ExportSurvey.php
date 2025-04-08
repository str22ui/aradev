<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSurvey implements FromView
{
    protected $survey;

    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    public function view(): View
    {
        return view('admin.survey.tableSurvey', ['survey' => $this->survey]);
    }
}
