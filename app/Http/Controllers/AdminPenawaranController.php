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
use App\Models\Affiliate;
use App\Models\Rumah;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Penawaran;
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
        return view('admin.penawaran.index', compact('penawaran', 'users'));
    }


    public function createPenawaran()
    {
        $user = Auth::user();

        if ($user->role === 'sales') {
            $perumahan = $user->perumahans;
        } else {
            $perumahan = Perumahan::all();
        }

        $agent = Agent::all();
        $affiliate = Affiliate::all();
        $rumah = Rumah::where('status', 'Available')->orderBy('no_kavling', 'asc')->get();

        return view('admin.penawaran.createPenawaran', compact('perumahan', 'agent', 'affiliate', 'rumah'));
    }

    public function storePenawaran(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'nullable|email',
            'no_hp' => 'required',
            'domisili' => 'required',
            'pekerjaan' => 'required',
            'nama_kantor' => 'nullable',
            'sumber_informasi' => 'required',
            'perumahan_id' => 'required',
            'rumah_id' => 'required',
            'agent_id' => 'nullable',
            'affiliate_id' => 'nullable',
            'payment' => 'required',
            'income' => 'required',
            'dp' => 'required',
            'harga_pengajuan' => 'required',
            'user_id' => 'nullable',
        ]);

        try {
            Penawaran::create($validatedData);
            return redirect('/penawaran')->with('success', 'Penawaran berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }


    public function editPenawaran($id)
    {
        $penawaran = Penawaran::find($id);
        $perumahan = Perumahan::all();
        $agent = Agent::all();
        $affiliate = Affiliate::all();

        // Ambil rumah berdasarkan perumahan penawaran
        $rumah = Rumah::where('perumahan_id', $penawaran->perumahan_id)
            ->orderBy('no_kavling', 'asc')
            ->get();

        if (!$penawaran) {
            return redirect()->route('admin.penawaran')->with('error', 'Data Penawaran tidak ditemukan');
        }

        return view('admin.penawaran.editPenawaran', compact('penawaran', 'perumahan', 'agent', 'affiliate', 'rumah'));
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
        $penawaran->affiliate_id = $request->input('affiliate_id');
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
