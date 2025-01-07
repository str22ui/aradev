<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    // public function indexStruktur()

    // {
    //     $structure = Management::first()->get();

    //     $structChunk = $structure->chunk(3);

    //     return view('client.page.akademik.struktur', compact([

    //         'structChunk',
    //     ]));

    // }


    public function indexStruktur()
    {
      $todayDate = Carbon::now()->format('Y-m-d');
      $monthDate = Carbon::now()->format('m');

      $totalVisits = Visit::count();
      $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
      $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

      $structure = Management::get();
      $structChunk = $structure->chunk(3);

      return view('client.page.akademik.struktur', compact([
        'structChunk',
        'totalVisits',
        'todayVisits',
        'monthVisits',
      ]));
    }

    public function indexGuru()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();
        $teachers = Management::with('position')->orderBy('id', 'asc')->get();

        return view('client.page.akademik.karyawan', compact([
            'teachers',
            'totalVisits',
            'todayVisits',
            'monthVisits',
        ]));
    }
}
