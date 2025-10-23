<?php

namespace App\Http\Controllers;

use App\Models\Perumahan;
use App\Models\Reseller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminResellerController extends Controller
{
    // ============ START Reseller ===========

     public function indexReseller()
     {
         $reseller = Reseller::all();
         $perumahan = Perumahan::all();
         $user = Auth::user();
         return view('admin.reseller.index', [
             'reseller' => $reseller,
             'user' => $user,
             'perumahan' => $perumahan,
         ]);
     }

     public function createReseller(){
        $perumahan= Perumahan::all();
        // return view('admin.agent.createAgent', compact('perumahan'));
        return view('admin.reseller.createReseller', compact('perumahan'));
    }

    public function storeReseller(Request $request)
    {
        $validatedData = $request->validate([

            'name' => 'required',
            'no_hp' => 'required',
            'pekerjaan' => 'required',
            'kota' => 'required',
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
            'role' => 'reseller',
        ]);

        // 2️⃣ Buat profil agent
        $resellerData = [
            'name' => $validatedData['name'],
            'no_hp' => $validatedData['no_hp'],
            'pekerjaan' => $validatedData['pekerjaan'],
            'kota' => $validatedData['kota'],
            'alamat' => $validatedData['alamat'],
            'referral_code' => $validatedData['referral_code'],
            'user_id' => $user->id,
        ];
         if (isset($validatedData['perumahan_id'])) {
            $resellerData['perumahan_id'] = json_encode($validatedData['perumahan_id']);
        }
        Reseller::create($resellerData);
        return redirect('/reseller')->with('success', 'Berhasil Menambahkan Reseller');
    }


    public function editReseller($id)
    {
        $reseller = Reseller::find($id);

        if (!$reseller) {
            return redirect()->route('admin.reseller')->with('error', 'Data Reseller tidak ditemukan');
        }

         // Decode JSON perumahan_id
        $reseller->perumahan_id = json_decode($reseller->perumahan_id, true);

        // Ambil data perumahan berdasarkan ID yang ada di perumahan_id
         $perumahan = Perumahan::all();

        return view('admin.reseller.editReseller', [
            'reseller' => $reseller,
            'perumahan' => $perumahan,
        ]);
    }



    public function updateReseller(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|max:255',
            'no_hp' => 'required|max:255',
            'pekerjaan' => 'required|max:255',
            'kota' => 'required|max:255',
            'alamat' => 'required|max:255',
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
            'referral_code' => 'required|max:255',
        ]);

        // Temukan agent berdasarkan id
        $reseller = Reseller::find($id);

        // Update agent data
        $reseller->update([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'perumahan_id' => json_encode($request->perumahan_id),
            'referral_code' => $request->referral_code,
        ]);

        // Simpan perubahan
        $reseller->save();

        // Redirect kembali ke halaman agent
        return redirect('/reseller')->with('success', 'Reseller berhasil diperbarui!');
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
