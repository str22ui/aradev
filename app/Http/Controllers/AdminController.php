<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Exports\ExportReport;
use App\Exports\ExportKonsumen;
use App\Exports\ExportSurvey;
use App\Exports\ExportPenawaran;
use App\Exports\ExportAgent;
use App\Exports\ExportReseller;

use Illuminate\Support\Facades\Log;


use Maatwebsite\Excel\Facades\Excel;

use App\Models\Visit;
use App\Models\Perumahan;
use App\Models\User;
use App\Models\Secondary;
use App\Models\Rumah;
use App\Models\Konsumen;
use App\Models\Survey;
use App\Models\Land;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Report;
use App\Models\Penawaran;
use App\Models\PerumahanImage;
use App\Models\SecondaryImage;
use App\Models\LandImage;
use App\Models\Info;
use App\Models\InfoImage;
use App\Models\Service;
use App\Models\Wishlist;
use App\Models\ServiceImage;
use App\Models\Testimony;
use App\Models\TestimonyImage;
use App\Models\Announcement;
use Illuminate\Support\Str;
use App\Models\CategoryBursa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminController extends Controller
{
    public function indexUser()
    {

        $user = User::with('perumahans')->get();
        $perumahan = Perumahan::all();


        return view('admin.user.index', [
            // 'users' => $users,  // Changed variable name to plural for clarity
            'perumahan' => $perumahan,
            'user' => $user,
        ]);
    }
    public function createUser(){
        $perumahan= Perumahan::all();
        return view('admin.user.createUser', compact('perumahan'));
    }


    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // tambahkan validasi email unik
            'password' => 'required',
            'role' => 'required',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'exists:perumahan,id', // validasi bahwa ID perumahan valid
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        // Buat user dulu
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'role' => $validatedData['role'],
        ]);

        // Attach relasi ke tabel pivot jika ada data perumahan
        if ($request->has('perumahan_id')) {
            $user->perumahans()->attach($validatedData['perumahan_id']);
        }

        return redirect('/user-home')->with('success', 'Berhasil Menambahkan Data User');
    }


    public function editUser($id)
    {
        $user = User::with('perumahans')->find($id);
        $perumahan = Perumahan::all(); // This should return a collection

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        return view('admin.user.editUser', [
            'user' => $user,
            'perumahan' => $perumahan,
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'role' => 'required',
            'perumahan_id' => 'nullable|array',
        ]);

        // Ambil data perumahan
        $user = User::findOrFail($id);

        // Update data utama
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
        ]);

        // Simpan perubahan
        $user->perumahans()->sync($request->perumahan_id ?? []);

        return redirect()->route('admin.user')->with('success', 'Data User berhasil diperbarui.');
    }

    public function destroyUser(Request $request)
    {
        // Debug untuk melihat data yang diterima
        Log::info($request->id);

        // Ambil data perumahan berdasarkan ID
        $user = User::findOrFail($request->id);

        // Hapus data
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect('/user-home')->with('success', 'Berhasil Menghapus Data User');
    }

    // ============ END USER ================
    public function indexAdmin()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

        // $employee = Employee::all();

        return view('admin.index', compact([
            // 'employee',
            'totalVisits',
            'todayVisits',
            'monthVisits',
        ]));
    }



      public function exportExcel(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');

          if ($exportOption == 'all') {
              $konsumen = Konsumen::all();
          } elseif ($exportOption == 'month_year') {
              $konsumen = Konsumen::whereYear('created_at', $year)
                  ->whereMonth('created_at', $month)
                  ->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($konsumen->isEmpty()) {
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }

          return Excel::download(new ExportExcel($konsumen), "Konsumen.xlsx");
      }
      public function exportReport(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $report = null; // Initialize $report variable

          if ($exportOption == 'all') {
              $report = Report::all();
          } elseif ($exportOption == 'month_year') {
              $report = Report::where("tanggal", "LIKE", "%{$fil}%")->get();
              // $report = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $report = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($report->isEmpty()) {
              // return $report;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($report);

          // return $report;
          return Excel::download(new ExportReport($report), "Report.xlsx");
      }

      public function exportKonsumen(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $konsumen = null; // Initialize $konsumen variable

          if ($exportOption == 'all') {
              $konsumen = Konsumen::all();
          } elseif ($exportOption == 'month_year') {
              $konsumen = Konsumen::where("created_at", "LIKE", "%{$fil}%")->get();
              // $konsumen = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $konsumen = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($konsumen->isEmpty()) {
              // return $konsumen;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($konsumen);

          // return $konsumen;
          return Excel::download(new ExportKonsumen($konsumen), "Konsumen.xlsx");
      }

      public function exportSurvey(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $survey = null; // Initialize $konsumen variable

          if ($exportOption == 'all') {
              $survey = Survey::all();
          } elseif ($exportOption == 'month_year') {
              $survey = Survey::where("created_at", "LIKE", "%{$fil}%")->get();
              // $konsumen = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $konsumen = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($survey->isEmpty()) {
              // return $survey;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($konsumen);

          // return $konsumen;
          return Excel::download(new ExportSurvey($survey), "Survey.xlsx");
      }

      public function exportPenawaran(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $penawaran = null; // Initialize $penawaran variable

          if ($exportOption == 'all') {
              $penawaran = Penawaran::all();
          } elseif ($exportOption == 'month_year') {
              $penawaran = Penawaran::where("created_at", "LIKE", "%{$fil}%")->get();
              // $penawaran = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $penawaran = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($penawaran->isEmpty()) {
              // return $penawaran;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($penawaran);

          // return $konsumen;
          return Excel::download(new ExportPenawaran($penawaran), "Penawaran.xlsx");
      }

      public function exportAgent(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $perumahan = Perumahan::all();
          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $agents = null; // Initialize $agent variable

          if ($exportOption == 'all') {
              $agents = Agent::all();
          } elseif ($exportOption == 'month_year') {
              $agents = Agent::where("created_at", "LIKE", "%{$fil}%")->get();
              // $agent = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $agent = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($agents->isEmpty()) {
              // return $agent;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($agent);

          // return $konsumen;
          return Excel::download(new ExportAgent($agents), "Agent.xlsx");
      }

      public function exportReseller(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $reseller = null; // Initialize $reseller variable

          if ($exportOption == 'all') {
              $reseller = Reseller::all();
          } elseif ($exportOption == 'month_year') {
              $reseller = Reseller::where("created_at", "LIKE", "%{$fil}%")->get();
              // $reseller = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $reseller = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($reseller->isEmpty()) {
              // return $reseller;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($reseller);

          // return $konsumen;
          return Excel::download(new ExportReseller($reseller), "Reseller.xlsx");
      }


}
