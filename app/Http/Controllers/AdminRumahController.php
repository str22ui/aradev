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

class AdminRumahController extends Controller
{
      // ============ RUMAH ================
    public function indexRumah(Request $request)
{
    // Ambil list semua perumahan untuk dropdown
    $listPerumahan = Perumahan::all();

    // Query untuk mendapatkan data rumah, default menampilkan semua
    $query = Rumah::query();

    // Jika filter perumahan_id ada, tambahkan kondisi ke query
    if ($request->has('perumahan_id') && $request->perumahan_id != '') {
        $query->where('perumahan_id', $request->perumahan_id);
    }
    $rumah = $query->get()->sortBy(function ($item) {
        $kav = $item->no_kavling;

        // Jika hanya angka, urutkan secara numerik
        if (is_numeric($kav)) {
            return [0, intval($kav)];
        }

        // Jika campuran (bukan hanya angka), taruh setelah angka dan urutkan secara alfabetis
        return [1, strtolower($kav)];
    })->values(); // reset indeks collection

    return view('admin.rumah.index', compact('rumah', 'listPerumahan'));
}

     public function createRumah(){
        $perumahan= Perumahan::all();
        return view('admin.rumah.createRumah', compact('perumahan'));
        // return view('admin.rumah.createRumah');
    }

    public function storeRumah(Request $request)
    {
        $validatedData = $request->validate([

            'no_kavling' => 'required',
            'luas_tanah' => 'nullable',
            'luas_bangunan' => 'nullable',
            'posisi' => 'required',
            'harga' => 'required',
            'perumahan_id' => 'required|numeric',
            'status' => 'required',
        ]);

        Rumah::create($validatedData);
        return redirect('/rumah')->with('success', 'Berhasil Menambahkan Rumah');
    }


    public function editRumah($id)
    {
        // Coba temukan data agent berdasarkan ID
        $rumah = Rumah::find($id);
        $perumahan= Perumahan::all();

        // Jika agent tidak ditemukan, tampilkan pesan error atau redirect
        if (!$rumah) {
            return redirect()->route('admin.agent')->with('error', 'Data Rumah tidak ditemukan');
        }

        // Jika ditemukan, kirim data ke view
        return view('admin.rumah.editRumah', [
            'rumah' => $rumah,
            'perumahan' => $perumahan,
        ]);
    }
    public function destroyRumah(Request $request)
    {
        // Ambil ID dari request
        \Log::info($request->id);

        $rumah = Rumah::findOrFail($request->id);

        // Hapus data
        $rumah->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/rumah')->with('success', 'Berhasil Menghapus Rumah');
    }
     public function updateRumah(Request $request, $id)
     {
         // Find the agent by id
         $rumah = Rumah::find($id);

         // Update the agent's data
         $rumah->no_kavling = $request->input('no_kavling');
         $rumah->luas_tanah = $request->input('luas_tanah');
         $rumah->luas_bangunan = $request->input('luas_bangunan');
         $rumah->posisi = $request->input('posisi');
         $rumah->harga = $request->input('harga');
         $rumah->perumahan_id = $request->input('perumahan_id');
         $rumah->status = $request->input('status');

         // Save the changes to the database
         $rumah->save();

         // Redirect back or to any other page
         return redirect('/rumah');
     }



    // ============ END RUMAH ================
}
