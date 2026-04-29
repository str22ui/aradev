<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Konsumen;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportKonsumen implements FromView
{
    protected $konsumen;
    protected $users;

    public function __construct($konsumen, $users = null)
    {
        $this->konsumen = $konsumen;
        $this->users = $users ?? User::all();
    }

    public function view(): View
    {
        return view('admin.konsumen.tableKonsumen', [
            'konsumen' => $this->konsumen,
            'users'    => $this->users,
        ]);
    }
}
