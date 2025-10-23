<?php

namespace App\Http\Controllers;

use App\Models\Perumahan;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Sales;
use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAffiliateController extends Controller
{


     // ============ START AGENT  ================

     public function indexAffiliate()
     {
         $affiliate = Affiliate::all();
         $perumahan = Perumahan::all();
         $user = Auth::user();
         $agents= Agent::all();
         return view('admin.affiliate.index', [
              'affiliate' => $affiliate,
              'user' => $user,
              'agents' => $agents,
              'perumahan' => $perumahan,
         ]);
     }

     public function createAffiliate(){
        $perumahan = Perumahan::all();
        $user = User::all();       // ambil semua admin
        $agents = Agent::all();       // ambil semua agent
        return view('admin.affiliate.createAffiliate', compact('perumahan', 'user', 'agents'));
    }

   public function storeAffiliate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'referral_code' => 'required',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'exists:perumahan,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // 1️⃣ Buat user login affiliate
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'affiliate',
        ]);

        // 2️⃣ Cari pemilik kode referral (agent/reseller)
        $referrerAgent = Agent::where('referral_code', $request->referral_code)->first();
        $referrerReseller = Reseller::where('referral_code', $request->referral_code)->first();

        if ($referrerAgent) {
            $referrerUserId = $referrerAgent->user_id;
            $referrerName = $referrerAgent->name;
        } elseif ($referrerReseller) {
            $referrerUserId = $referrerReseller->user_id;
            $referrerName = $referrerReseller->name;
        } else {
            $referrerUserId = null;
            $referrerName = null;
        }

        // 3️⃣ Buat affiliate baru dan hubungkan dengan referrer
        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'code' => strtoupper(Str::random(6)),
            'referred_by_name' => $referrerName,
            'referred_by_user_id' => $referrerUserId,
            'referred_by_code' => $request->referral_code,
            'commission_rate' => 0, // default, bisa diisi nanti
            'joined_at' => now(),
        ]);

       if (isset($validatedData['perumahan_id'])) {
            $affiliate->perumahan_id = json_encode($validatedData['perumahan_id']);
            $affiliate->save();
        }




        return redirect('/affiliate')->with('success', 'Affiliate berhasil dibuat dan otomatis terhubung ke referrer!');
    }



    public function editAffiliate($id)
    {
        $affiliate = Affiliate::find($id);

        if (!$affiliate) {
            return redirect()->route('admin.affiliate')->with('error', 'Data Affiliate tidak ditemukan');
        }

         // Decode JSON perumahan_id
        $affiliate->perumahan_id = json_decode($affiliate->perumahan_id, true);

        // Ambil data perumahan berdasarkan ID yang ada di perumahan_id
         $perumahan = Perumahan::all();

        return view('admin.affiliate.editAffiliate', [
            'affiliate' => $affiliate,
            'perumahan' => $perumahan,
        ]);
    }



    public function updateAffiliate(Request $request, $id)
    {
        // 1️⃣ Validasi input
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'referral_code' => 'nullable',
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
        ]);

        // 2️⃣ Cari affiliate
        $affiliate = Affiliate::findOrFail($id);

        // 3️⃣ Cari referrer baru jika referral_code diisi
        $referrerAgent = Agent::where('referral_code', $request->referral_code)->first();
        $referrerReseller = Reseller::where('referral_code', $request->referral_code)->first();

        if ($referrerAgent) {
            $referrerUserId = $referrerAgent->user_id;
            $referrerName = $referrerAgent->name;
        } elseif ($referrerReseller) {
            $referrerUserId = $referrerReseller->user_id;
            $referrerName = $referrerReseller->name;
        } else {
            $referrerUserId = $affiliate->referred_by_user_id; // biarkan default
            $referrerName = $affiliate->referred_by_name;
        }

        // 4️⃣ Update affiliate
        $affiliate->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'referred_by_name' => $referrerName,
            'referred_by_user_id' => $referrerUserId,
            'referred_by_code' => $request->referral_code ?? $affiliate->referred_by_code,
            'perumahan_id' => json_encode($request->perumahan_id),
        ]);

        return redirect('/affiliate')->with('success', 'Affiliate berhasil diperbarui!');
    }



    public function destroyAffiliate(Request $request)
    {
        // Ambil ID dari request
        $affiliate = Affiliate::findOrFail($request->id);

        // Hapus data
        $affiliate->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/affiliate')->with('success', 'Berhasil Menghapus Affiliate');
    }

    // ============ END AGENT ================
}
