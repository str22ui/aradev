<?php

namespace App\Http\Controllers;


use Carbon\Carbon;

use App\Exports\ExportReport;
use App\Exports\ExportKonsumen;
use App\Exports\ExportSurvey;
use App\Exports\ExportPenawaran;
use App\Exports\ExportAgent;
use App\Exports\ExportReseller;
use App\Models\Affiliate;
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

class AdminKonsumenController extends Controller
{
     // ============ KONSUMEN ================
    public function indexKonsumen()
    {
        $user = Auth::user();

        // Jika role-nya salesAdmin, hanya tampilkan data konsumen yang sesuai user_id
        if ($user->role === 'sales') {
            $konsumen = Konsumen::with('agent')
                ->where('user_id', $user->id)
                ->get();
        } else {
            // Jika admin atau role lainnya, tampilkan semua
            $konsumen = Konsumen::with('agent')->get();
        }
         $users = User::all();
        return view('admin.konsumen.index', [
            'konsumen' => $konsumen,
            'users' => $users,
        ]);
    }

  public function createKonsumen()
    {
        $user = Auth::user();

        if ($user->role === 'sales') {
            // Ambil hanya perumahan yang di-assign lewat pivot ke user
            $perumahan = $user->perumahans;
        } else {
            // Admin dan lainnya bisa lihat semua
            $perumahan = Perumahan::all();
        }

        $agent = Agent::all();
        $affiliate = Affiliate::all();

        return view('admin.konsumen.createKonsumen', compact('perumahan', 'agent', 'affiliate'));
    }



    public function storeKonsumen(Request $request)
    {
        $validatedData = $request->validate([
            'nama_konsumen' => 'required',
            'no_hp' => 'required',
            'domisili' => 'nullable',
            'email' => 'nullable|email',
            'pekerjaan' => 'nullable',
            'nama_kantor' => 'nullable',
            'perumahan' => 'required|not_in:pilih',
            'sumber_informasi' => 'required|not_in:-- Pilih --',
            'agent_id' => 'nullable|exists:agents,id',
            'affiliate_id' => 'nullable|exists:affiliates,id',
            'user_id' => 'nullable',
        ]);

        // Pastikan nilai 'agent_id' dan 'reseller_id' menjadi null jika tidak dipilih
        $validatedData['agent_id'] = $request->filled('agent_id') ? $request->input('agent_id') : null;
        $validatedData['affiliate_id'] = $request->filled('affiliate_id') ? $request->input('affiliate_id') : null;

        // Set created_at dari input atau waktu sekarang
        $validatedData['created_at'] = $request->input('tanggal') ?? Carbon::now();

        Konsumen::create($validatedData);

        return redirect('/konsumen')->with('success', 'Konsumen berhasil disimpan.');
    }




    public function destroyKonsumen(Request $request)
    {
        // Ambil ID dari request
        $konsumen = Konsumen::findOrFail($request->id);

        // Hapus data
        $konsumen->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/konsumen')->with('success', 'Berhasil Menghapus Konsumen');
    }

    public function editKonsumen($id)
    {
        // Coba temukan data konsumen berdasarkan ID
        $konsumen = Konsumen::find($id);
        $rumah = Rumah::find($id);
        $perumahan = Perumahan::all();
        $agent = Agent::all();
        $reseller = Reseller::all();

        // Jika konsumen tidak ditemukan, tampilkan pesan error atau redirect
        if (!$konsumen) {
            return redirect()->route('admin.konsumen')->with('error', 'Data Konsumen tidak ditemukan');
        }

        // Jika ditemukan, kirim data ke view
        return view('admin.konsumen.editKonsumen', [
            'konsumen' => $konsumen,
            'perumahan' => $perumahan,
            'agent' => $agent,
            'reseller' => $reseller,
            'rumah' => $rumah,
        ]);
    }

    public function updateKonsumen(Request $request, $id)
    {
        // Find the agent by id
        $konsumen = konsumen::find($id);

        // Update the agent's data
        $konsumen->nama_konsumen = $request->input('nama_konsumen');
        $konsumen->no_hp = $request->input('no_hp');
        $konsumen->domisili = $request->input('domisili');
        $konsumen->email = $request->input('email');
        $konsumen->pekerjaan = $request->input('pekerjaan');
        $konsumen->nama_kantor = $request->input('nama_kantor');
        $konsumen->perumahan = $request->input('perumahan');
        $konsumen->sumber_informasi = $request->input('sumber_informasi');
        $konsumen->agent_id = $request->input('agent_id');
        $konsumen->reseller_id = $request->input('reseller_id');
        $konsumen->user_id = $request->input('user_id');

        // Save the changes to the database
        $konsumen->save();

        // Redirect back or to any other page
        return redirect('/konsumen');
    }

    public function updateUserIdKonsumen(Request $request, $id)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $konsumen = Konsumen::findOrFail($id);
            $konsumen->user_id = $request->user_id;
            $konsumen->save();

            return redirect()->back()->with('success', 'User berhasil diperbarui');
        }
    // ============ END KONSUMEN ================
}
