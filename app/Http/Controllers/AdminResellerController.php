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
class AdminResellerController extends Controller
{
    // ============ START Reseller ===========

     public function indexReseller()
     {

         $reseller = Reseller::all();
         $user = Auth::user();
         return view('admin.reseller.index', [
             'reseller' => $reseller,
         ]);
     }

     public function createReseller(){
        // $perumahan= Perumahan::all();
        // return view('admin.agent.createAgent', compact('perumahan'));
        return view('admin.reseller.createReseller');
    }

    public function storeReseller(Request $request)
    {
        $validatedData = $request->validate([

            'nama' => 'required',
            'no_hp' => 'required',
            'pekerjaan' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
        ]);
        Reseller::create($validatedData);
        return redirect('/reseller')->with('success', 'Berhasil Menambahkan Reseller');
    }


    public function editReseller($id)
    {
        $reseller = Reseller::find($id);

        if (!$reseller) {
            return redirect()->route('admin.reseller')->with('error', 'Data Agent tidak ditemukan');
        }

        // Decode JSON perumahan_id
        // $agent->perumahan_id = json_decode($agent->perumahan_id, true);

        // // Ambil data perumahan berdasarkan ID yang ada di perumahan_id
        //  $perumahan = Perumahan::all();


        return view('admin.reseller.editReseller', [
            'reseller' => $reseller,
            // 'perumahan' => $perumahan,
        ]);
    }



    public function updateReseller(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|max:255',
            'no_hp' => 'required|max:255',
            'pekerjaan' => 'required|max:255',
            'kota' => 'required|max:255',
            'alamat' => 'required|max:255',
        ]);

        // Temukan agent berdasarkan id
        $reseller = Reseller::find($id);

        // Update agent data
        $reseller->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
        ]);

        // Simpan perubahan
        $reseller->save();

        // Redirect kembali ke halaman agent
        return redirect('/reseller');
    }



    public function destroyReseller(Request $request)
    {
        // Ambil ID dari request
        $reseller = Reseller::findOrFail($request->id);

        // Hapus data
        $reseller->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/reseller')->with('success', 'Berhasil Menghapus Reseller');
    }

      // ============ END RESELLER ================

}
