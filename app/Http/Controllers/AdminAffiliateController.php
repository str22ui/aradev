<?php

namespace App\Http\Controllers;

use App\Models\Perumahan;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Sales;
use App\Models\Affiliate;
use App\Models\AffiliatesCommision;
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

        // 3️⃣ Buat affiliate baru dan hubungkan dengan referrer
        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'code' => strtoupper(Str::random(6)),
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
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
        ]);

        // 2️⃣ Cari affiliate
        $affiliate = Affiliate::findOrFail($id);

        // 4️⃣ Update affiliate
        $affiliate->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
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


    public function createCommission($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $perumahan = Perumahan::all();

        // Ambil data komisi yang sudah ada untuk affiliate ini
        $commissions = AffiliatesCommision::where('affiliate_id', $id)
            ->with('perumahan')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('admin.affiliate.commision_create', compact('affiliate', 'perumahan', 'commissions'));
    }



    public function storeCommission(Request $request, $id)
    {
        $request->validate([
            'bulan' => 'required|date',
            'harga_pricelist' => 'required|numeric',
            'biaya_legalitas' => 'required|numeric',
            'net_price' => 'required|numeric',
            'fee_2_5' => 'required|numeric',
            'fee_affiliate_30' => 'required|numeric',
            'sub_total_bulanan' => 'required|numeric',
            'total' => 'required|numeric',
            'perumahan_id' => 'required|exists:perumahan,id',
        ]);

        AffiliatesCommision::create([
        'affiliate_id' => $id,
        'user_id' => Affiliate::find($id)->user_id, // ambil user_id dari affiliate
        'perumahan_id' => $request->perumahan_id,
        'bulan' => $request->bulan,
        'harga_pricelist' => $request->harga_pricelist,
        'biaya_legalitas' => $request->biaya_legalitas,
        'net_price' => $request->net_price,
        'fee_2_5' => $request->fee_2_5,
        'fee_affiliate_30' => $request->fee_affiliate_30,
        'sub_total_bulanan' => $request->sub_total_bulanan,
        'total' => $request->total,


    ]);


        return redirect()->route('admin.affiliate')->with('success', 'Data komisi berhasil disimpan!');
    }
        public function deleteCommission($id)
        {
            $commission = AffiliatesCommision::findOrFail($id);
            $affiliateId = $commission->affiliate_id;
            $commission->delete();

            return redirect()
                ->route('admin.createCommission', $affiliateId)
                ->with('success', 'Komisi berhasil dihapus');
        }
    }
