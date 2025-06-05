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
class AdminAgentController extends Controller
{


     // ============ START AGENT  ================

     public function indexAgent()
     {
         $perumahan = Perumahan::all();
         $agents = Agent::all();
         $user = Auth::user();
         return view('admin.agent.index', [
             'agents' => $agents,
             'perumahan' => $perumahan,
             // 'user' => $user,
         ]);
     }

     public function createAgent(){
        $perumahan= Perumahan::all();
        return view('admin.agent.createAgent', compact('perumahan'));
    }

    public function storeAgent(Request $request)
    {
        $validatedData = $request->validate([

            'nama' => 'required',
            'kantor' => 'nullable',
            'tipe' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'string|max:255',
        ]);
        if ($request->has('perumahan_id')) {
            $validatedData['perumahan_id'] = json_encode($request->perumahan_id);
        }
        Agent::create($validatedData);
        return redirect('/agent')->with('success', 'Berhasil Menambahkan Agent');
    }


    public function editAgent($id)
    {
        $agent = Agent::find($id);

        if (!$agent) {
            return redirect()->route('admin.agent')->with('error', 'Data Agent tidak ditemukan');
        }

        // Decode JSON perumahan_id
        $agent->perumahan_id = json_decode($agent->perumahan_id, true);

        // Ambil data perumahan berdasarkan ID yang ada di perumahan_id
         $perumahan = Perumahan::all();


        return view('admin.agent.editAgent', [
            'agent' => $agent,
            'perumahan' => $perumahan, // Data perumahan yang cocok
        ]);
    }



    public function updateAgent(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|max:255',
            'tipe' => 'required|string  ',
            'kantor' => 'required|string    ',
            'no_hp' => 'required|max:255',
            'alamat' => 'required|max:255',
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
        ]);

        // Temukan agent berdasarkan id
        $agent = Agent::find($id);

        // Update agent data
        $agent->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'kantor' => $request->kantor,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'perumahan_id' => json_encode($request->perumahan_id),
        ]);

        // Simpan perubahan
        $agent->save();

        // Redirect kembali ke halaman agent
        return redirect('/agent');
    }



    public function destroyAgent(Request $request)
    {
        // Ambil ID dari request
        $agent = Agent::findOrFail($request->id);

        // Hapus data
        $agent->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/agent')->with('success', 'Berhasil Menghapus Agent');
    }

    // ============ END AGENT ================
}
