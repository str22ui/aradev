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

class AdminPenawaranController extends Controller
{

    // ============ PENAWARAN ================
   public function indexPenawaran()
    {
        $user = Auth::user();

        if ($user->role === 'sales') {
            $penawaran = Penawaran::with(['agent', 'perumahan', 'rumah'])
                ->where('user_id', $user->id)
                ->get();
        } else {
            $penawaran = Penawaran::with(['agent', 'perumahan', 'rumah'])->get();
        }

        $users = User::all();
        return view('admin.penawaran.index', compact('penawaran','users'));
    }


    public function createPenawaran()
    {
        $perumahan= Perumahan::all();
        $agent = Agent::all();
        // $rumah = Rumah::where('perumahan_id', $id)->orderBy('no_kavling', 'asc')->get();
        return view('admin.penawaran.createPenawaran', compact('perumahan','agent'));
    }

    public function storePenawaran(Request $request)
        {
            $validatedData = $request->validate([
                'nama_konsumen' => 'required',
                'no_hp' => 'required',
                'domisili' => 'nullable',
                'email' => 'nullable|email',
                'pekerjaan' => 'nullable',
                'nama_kantor' => 'nullable',
                'perumahan' => 'required',
                'sumber_informasi' => 'required',
                'agent_id' => 'nullable',
                'user_id' => 'nullable',
            ]);

           // Jika agent_id adalah 'pilih', set ke null
            if ($request->input('agent_id') === 'pilih') {
                $validatedData['agent_id'] = null;
            } else {
                $validatedData['agent_id'] = $request->input('agent_id');
            }

            // Set created_at ke tanggal dari input atau tanggal saat ini jika tidak diisi
            $validatedData['created_at'] = $request->input('tanggal') ? $request->input('tanggal') : Carbon::now();

            try {
                Konsumen::create($validatedData);
                return redirect('/konsumen')->with('success', 'Konsumen berhasil disimpan.');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
            }
    }


    public function editPenawaran($id)
    {
        // Coba temukan data konsumen berdasarkan ID
        $penawaran = Penawaran::find($id);
        // $perumahan = Perumahan::find($id);
        $perumahan = Perumahan::all();
        $rumah = Rumah::find($id);
        $agent = Agent::all();
        $reseller = Reseller::all();

        // Jika konsumen tidak ditemukan, tampilkan pesan error atau redirect
        if (!$penawaran) {
            return redirect()->route('admin.penawaran')->with('error', 'Data Konsumen tidak ditemukan');
        }

        // Jika ditemukan, kirim data ke view
        return view('admin.penawaran.editPenawaran', [
            'penawaran' => $penawaran,
            'perumahan' => $perumahan,
            'rumah' => $rumah,
            'agent' => $agent,
            'reseller' => $reseller,
        ]);
    }


    public function updatePenawaran(Request $request, $id)
    {
        // Find the agent by id
        $penawaran = Penawaran::find($id);

        // Update the agent's data
        $penawaran->nama = $request->input('nama');
        $penawaran->email = $request->input('email');
        $penawaran->no_hp = $request->input('no_hp');
        $penawaran->domisili = $request->input('domisili');
        $penawaran->pekerjaan = $request->input('pekerjaan');
        $penawaran->nama_kantor = $request->input('nama_kantor');
        $penawaran->payment = $request->input('payment');
        $penawaran->income = $request->input('income');
        $penawaran->dp = $request->input('dp');
        $penawaran->harga_pengajuan = $request->input('harga_pengajuan');
        $penawaran->sumber_informasi = $request->input('sumber_informasi');
        $penawaran->agent_id = $request->input('agent_id');
        $penawaran->reseller_id = $request->input('reseller_id');
        $penawaran->user_id = $request->input('user_id');
        // $penawaran->perumahan = $request->input('perumahan');

        // Save the changes to the database
        $penawaran->save();

        // Redirect back or to any other page
        return redirect('/penawaran');
    }

    public function destroyPenawaran(Request $request)
    {
        // Ambil ID dari request
        $penawaran = Penawaran::findOrFail($request->id);

        // Hapus data
        $penawaran->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/penawaran')->with('success', 'Berhasil Menghapus Konsumen');
    }

    public function updateUserIdPenawaran(Request $request, $id)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $penawaran = Penawaran::findOrFail($id);
            $penawaran->user_id = $request->user_id;
            $penawaran->save();

            return redirect()->back()->with('success', 'User berhasil diperbarui');
        }
    // ============ END PENAWARAN ================

}
