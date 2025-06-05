<?php

namespace App\Http\Controllers;


use Carbon\Carbon;

use App\Exports\ExportReport;
use App\Exports\ExportKonsumen;
use App\Exports\ExportSurvey;
use App\Exports\ExportPenawaran;
use App\Exports\ExportAgent;
use App\Exports\ExportReseller;

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

class AdminReportController extends Controller
{
     // ============ START REPORT  ================

      public function indexReport()
      {
        //   $report = Report::all();
          $report = Report::with('konsumen')->get();
          $user = Auth::user();
          return view('admin.report.index', [
              'report' => $report,
              // 'user' => $user,
          ]);
      }

    public function createReport(){
        $user = auth()->user();

        $konsumen = Konsumen::all();
        $username = $user->name;
        return view('admin.report.createReport', compact('konsumen', 'username'));
    }

    public function getKonsumen($id)
    {
        $konsumen = Konsumen::find($id);
        return response()->json([
            'no_hp' => $konsumen->no_hp,
            'perumahan' => $konsumen->perumahan, // pastikan ini diambil dari database
            'sumber_informasi' => $konsumen->sumber_informasi,
            'PIC' => $konsumen->PIC,
        ]);
    }
    public function storeReport(Request $request)
    {


        $validatedData = $request->validate([
            'konsumen_id' => 'required',
            'pic' => 'nullable',
            'follow_up' => 'required',
            'status' => 'required',
            'no_hp' => 'required',
            // 'perumahan' =>   'required',
           'tanggal' => 'required|date|date_format:Y-m-d',
            // 'sumber_informasi' => 'required',
            'alasan' => 'nullable',
            'koresponden' => 'required',

        ]);

        if ($request->filled('tanggal')) {
            $validatedData['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        }
        // Cek duplikasi data
        $existingReport = Report::where('konsumen_id', $request->konsumen_id)
            ->where('no_hp', $request->no_hp)
            ->first();

        if ($existingReport) {
            return redirect()->back()->withErrors(['error' => 'Data dengan nama konsumen dan nomor HP yang sama sudah ada.']);
        }
        // Buat laporan dengan data yang disediakan dalam form
        Report::create($validatedData);

        return redirect('/report')->with('success', 'Report berhasil ditambahkan.');
    }

    public function editReport($id)
    {
        $konsumen = Konsumen::all();
        $report = Report::findOrFail($id);

        return view('admin.report.editReport', [
            'report' => $report,
            'konsumen' => $konsumen

        ]);
    }

    public function updateReports(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'nullable',
            'follow_up' => 'nullable',
            'koresponden' => 'nullable',
            'alasan' => 'nullable',
        ]);

        $report = Report::findOrFail($id);

        // Periksa apakah follow_up telah diisi di formulir
        if (!$request->filled('follow_up')) {
            // Biarkan follow up tetap sama jika tidak diubah di formulir
            $validatedData['follow_up'] = $report->follow_up;
        }

        // Periksa apakah tanggal telah diisi di formulir, dan lakukan perubahan seperti sebelumnya

        $report->update($validatedData);

        // Redirect back or to any other page
        return redirect('/report')->with('success', 'Report berhasil diperbarui.');
    }



    public function addReports($id)
    {
        $user = auth()->user();

        $report = Report::with('konsumen')->findOrFail($id);
        $username = $user->name;

        return view('admin.report.addReport', [
            'report' => $report,
            'konsumen' => $report->konsumen,
            'username' => $username,

        ]);
    }

    public function addedReports(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'nullable',
            'follow_up' => 'nullable',
            'koresponden' => 'nullable',
            'alasan' => 'nullable',

        ]);

        $report = Report::findOrFail($id);

        // Proses field follow_up
        if ($request->filled('follow_up')) {
            $newFollowUp = $this->incrementFollowUp($report->follow_up);
            $validatedData['follow_up'] = $report->follow_up ? $report->follow_up . "\n" . $newFollowUp : $newFollowUp;
        } else {
            $validatedData['follow_up'] = $report->follow_up;
        }



        // Proses field koresponden
        if ($request->filled('koresponden')) {
            $validatedData['koresponden'] = $report->koresponden ? $report->koresponden . "\n" . $request->koresponden : $request->koresponden;
        } else {
            $validatedData['koresponden'] = $report->koresponden;
        }

        // Proses field status
        if ($request->filled('status')) {
            $validatedData['status'] = $report->status ? $report->status . "\n" . $request->status : $request->status;
        } else {
            $validatedData['status'] = $report->status;
        }

        // Proses field keterangan
        if ($request->filled('alasan')) {
            $validatedData['alasan'] = $report->alasan ? $report->alasan . "\n" . $request->alasan : $request->alasan;
        } else {
            $validatedData['alasan'] = $report->alasan;
        }

        // Tambahkan tanggal hari ini ke field updated
        $validatedData['updated'] = $report->updated ? $report->updated . "\n" . Carbon::now()->toDateString() : Carbon::now()->toDateString();

        // Isi kolom PIC dengan data yang dikirimkan melalui form
        // dan tambahkan nama PIC dari user yang sedang login
        $user = auth()->user();
        $validatedData['pic'] = $report->pic ? $report->pic . "\n" . $user->name : $user->name;

        $report->update($validatedData);

        // Redirect back or to any other page
        return redirect('/report')->with('success', 'Report berhasil diperbarui.');
    }



    private function incrementFollowUp($currentFollowUp)
    {
        if (!$currentFollowUp) {
            return "FU1";
        }

        $followUps = explode("\n", $currentFollowUp);
        $lastFollowUp = end($followUps);

        if (preg_match('/^FU(\d+)$/', $lastFollowUp, $matches)) {
            $currentNumber = (int)$matches[1];
            $nextNumber = $currentNumber + 1;
            // Batasi hingga FU20
            if ($nextNumber > 20) {
                $nextNumber = 20;
            }
            return "FU" . $nextNumber;
        }

        // Default jika tidak sesuai format
        return "FU1";
    }

    public function destroyReport(Request $request)
    {
        // Ambil ID dari request
        $report = Report::findOrFail($request->id);

        // Hapus data
        $report->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/report')->with('success', 'Berhasil Menghapus Report');
    }

      // ============ END REPORT ================
}
