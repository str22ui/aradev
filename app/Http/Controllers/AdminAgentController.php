<?php

namespace App\Http\Controllers;

use App\Models\Perumahan;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
        'name' => 'required',
        'kantor' => 'nullable',
        'tipe' => 'required',
        'no_hp' => 'required',
        'alamat' => 'required',
        'referral_code' => 'required',
        'perumahan_id' => 'nullable|array',
        'perumahan_id.*' => 'exists:perumahan,id',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

        // 1️⃣ Buat user login dulu
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'agent',
        ]);

        // 2️⃣ Buat profil agent
        $agentData = [
            'name' => $validatedData['name'],
            'kantor' => $validatedData['kantor'],
            'tipe' => $validatedData['tipe'],
            'no_hp' => $validatedData['no_hp'],
            'alamat' => $validatedData['alamat'],
            'referral_code' => $validatedData['referral_code'],
            'user_id' => $user->id,
        ];

        if (isset($validatedData['perumahan_id'])) {
            $agentData['perumahan_id'] = json_encode($validatedData['perumahan_id']);
        }

        Agent::create($agentData);

        return redirect('/agent')->with('success', 'Berhasil menambahkan Agent & User login');
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
            'name' => 'required|max:255',
            'tipe' => 'required|string  ',
            'kantor' => 'required|string    ',
            'no_hp' => 'required|max:255',
            'alamat' => 'required|max:255',
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
            'referral_code' => 'required',
        ]);

        // Temukan agent berdasarkan id
        $agent = Agent::find($id);

        // Update agent data
        $agent->update([
            'name' => $request->name,
            'tipe' => $request->tipe,
            'kantor' => $request->kantor,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'perumahan_id' => json_encode($request->perumahan_id),
            'referral_code' => $request->referral_code,
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
