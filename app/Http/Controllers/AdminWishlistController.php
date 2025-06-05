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

class AdminWishlistController extends Controller
{

    // ============ START WISHLIST  ================

     public function indexWishlist()
     {
         $wishlist = Wishlist::all();
         $user = Auth::user();
         return view('admin.wishlist.index', [
             'wishlist' => $wishlist,
             // 'user' => $user,
         ]);
     }

     public function createWishlist(){
        $wishlist= Wishlist::all();
        return view('admin.wishlist.createWishlist', compact('wishlist'));
    }

    public function storeWishlistt(Request $request)
    {
        $validatedData = $request->validate([

            'nama' => 'required',
            'no_hp' => 'required',
            'domisili' => 'nullable',
            'permintaan' => 'required',
            'jenis' => 'required',
            'lokasi' => 'required',
            'spesifik_lokasi' => 'required',
            'harga_budget' => 'required',
            'keterangan' => 'required',
            'approval' => 'required',
            'status' => 'required',

        ]);

        Wishlist::create($validatedData);
        return redirect('/admin-wishlist')->with('success', 'Berhasil Menambahkan wishlist');
    }


    public function editWishlist($id)
    {
        $wishlist = Wishlist::find($id);

        if (!$wishlist) {
            return redirect()->route('admin.wishlist')->with('error', 'Data wishlist tidak ditemukan');
        }

        return view('admin.wishlist.editWishlist', [
            'wishlist' => $wishlist,

        ]);
    }



    public function updateWishlist(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'domisili' => 'nullable',
            'permintaan' => 'required',
            'jenis' => 'required',
            'lokasi' => 'required',
            'spesifik_lokasi' => 'required',
            'harga_budget' => 'required',
            'keterangan' => 'required',
            'approval' => 'required',
            'status' => 'required',
        ]);

        // Temukan agent berdasarkan id
        $wishlist = Wishlist::find($id);

        // Update agent data
        $wishlist->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'domisili' => $request->domisili,
            'permintaan' => $request->permintaan,
            'jenis' => $request->jenis,
            'lokasi' => $request->lokasi,
            'spesifik_lokasi' => $request->spesifik_lokasi,
            'harga_budget' => $request->harga_budget,
            'keterangan' => $request->keterangan,
            'approval' => $request->approval,
            'status' => $request->status,
        ]);

        // Simpan perubahan
        $wishlist->save();

        // Redirect kembali ke halaman agent
        return redirect('/admin-wishlist');
    }



    public function destroyWishlist(Request $request)
    {
        // Ambil ID dari request
        $wishlist = Wishlist::findOrFail($request->id);

        // Hapus data
        $wishlist->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/admin-wishlist')->with('success', 'Berhasil Menghapus Wishlist');
    }

    // ============ END WISHLISTT ================
}
