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
    public function indexAffiliate()
    {
        $user = Auth::user();
        $perumahan = Perumahan::all();
        $agents = Agent::all();

        // Jika role Sales, hanya tampilkan affiliate miliknya
        if ($user->role === 'sales') {
            $affiliate = Affiliate::with('referrer')
                ->where('referrer_type', 'App\Models\User')
                ->where('referrer_id', $user->id)
                ->get();
        } else {
            // Admin / Super Admin tampil semua
            $affiliate = Affiliate::with('referrer')->get();
        }

        return view('admin.affiliate.index', [
            'affiliate' => $affiliate,
            'user' => $user,
            'agents' => $agents,
            'perumahan' => $perumahan,
        ]);
    }

    public function createAffiliate()
    {
        $perumahan = Perumahan::all();
        $user = User::all();
        $agents = Agent::all();

        // Ambil semua Sales untuk dropdown referrer
        $salesUsers = User::whereIn('role', ['sales', 'salesAdmin'])->get();

        return view('admin.affiliate.createAffiliate', compact('perumahan', 'user', 'agents', 'salesUsers'));
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
            'referrer_code' => 'nullable|string', // Kode referral Sales
        ]);

        // 1️⃣ Buat user login affiliate
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'affiliate',
        ]);

        // 2️⃣ Cari referrer berdasarkan kode
        $referrerType = null;
        $referrerId = null;

        if (!empty($validatedData['referrer_code'])) {
            // Cari Sales berdasarkan code
            $referrer = User::where('code', $validatedData['referrer_code'])
                ->whereIn('role', ['sales', 'salesAdmin'])
                ->first();

            if ($referrer) {
                $referrerType = User::class;
                $referrerId = $referrer->id;
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kode referral tidak valid atau bukan milik Sales');
            }
        }

        // 3️⃣ Buat affiliate baru dan hubungkan dengan referrer
        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'code' => strtoupper(Str::random(6)),
            'joined_at' => now(),
            'referrer_type' => $referrerType,
            'referrer_id' => $referrerId,
        ]);

        if (isset($validatedData['perumahan_id'])) {
            $affiliate->perumahan_id = json_encode($validatedData['perumahan_id']);
            $affiliate->save();
        }

        $message = $referrerType
            ? 'Affiliate berhasil dibuat dan otomatis terhubung ke referrer!'
            : 'Affiliate berhasil dibuat tanpa referrer!';

        return redirect('/affiliate')->with('success', $message);
    }

    public function editAffiliate($id)
    {
        $affiliate = Affiliate::with('referrer')->find($id);

        if (!$affiliate) {
            return redirect()->route('admin.affiliate')->with('error', 'Data Affiliate tidak ditemukan');
        }

        $affiliate->perumahan_id = json_decode($affiliate->perumahan_id, true);
        $perumahan = Perumahan::all();
        $salesUsers = User::whereIn('role', ['sales', 'salesAdmin'])->get();

        return view('admin.affiliate.editAffiliate', [
            'affiliate' => $affiliate,
            'perumahan' => $perumahan,
            'salesUsers' => $salesUsers,
        ]);
    }

    public function updateAffiliate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'string|max:255',
            'referrer_code' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed', // ← TAMBAH INI
        ]);

        $affiliate = Affiliate::findOrFail($id);

        // Update referrer jika ada perubahan
        if ($request->has('referrer_code')) {
            if (empty($request->referrer_code)) {
                // Kosongkan referrer jika field dikosongkan
                $affiliate->referrer_type = null;
                $affiliate->referrer_id = null;
            } else {
                // Cari Sales berdasarkan kode
                $referrer = User::where('code', $request->referrer_code)
                    ->whereIn('role', ['sales', 'salesAdmin'])
                    ->first();

                if ($referrer) {
                    $affiliate->referrer_type = User::class;
                    $affiliate->referrer_id = $referrer->id;
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Kode referral tidak valid');
                }
            }
        }

        // ← TAMBAH BAGIAN INI (Update password di tabel users)
        if ($request->filled('password')) {
            $user = User::find($affiliate->user_id);
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }
        // ← AKHIR BAGIAN BARU

        $affiliate->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            // 'perumahan_id' => json_encode($request->perumahan_id),
        ]);

        return redirect('/affiliate')->with('success', 'Affiliate berhasil diperbarui!');
    }
    public function destroyAffiliate(Request $request)
    {
        $affiliate = Affiliate::findOrFail($request->id);
        $affiliate->delete();

        return redirect('/affiliate')->with('success', 'Berhasil Menghapus Affiliate');
    }

    // Method baru untuk melihat affiliate dari Sales tertentu
    public function salesAffiliates($salesId)
    {
        $sales = User::findOrFail($salesId);

        if (!$sales->isSales()) {
            return redirect()->back()->with('error', 'User bukan Sales');
        }

        $affiliates = $sales->affiliatesReferred()->with('commissions')->get();

        return view('admin.affiliate.sales_affiliates', compact('sales', 'affiliates'));
    }

    public function createCommission($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $perumahan = Perumahan::all();

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
            'user_id' => Affiliate::find($id)->user_id,
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
