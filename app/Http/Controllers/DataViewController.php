<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\AffiliatesCommision;
use App\Models\Perumahan;
use App\Models\Agent;
use App\Models\Reseller;
use Illuminate\Support\Facades\Auth;

class DataViewController extends Controller
{
     public function dataViewAgent()
     {
         $agents = Agent::all();
         $user = Auth::user();
         return view('client.component.DataView.agent', [
              'agents' => $agents,
              'user' => $user,
         ]);
     }

    public function dataViewReseller()
     {
         $reseller = Reseller::all();
         $user = Auth::user();
         return view('client.component.DataView.reseller', [
              'reseller' => $reseller,
              'user' => $user,
         ]);
     }

    public function dataViewAffiliate()
    {
        $user = Auth::user();

        // Eager load relasi yang diperlukan
        $affiliate = Affiliate::with(['user', 'perumahan'])
            ->where('user_id', $user->id)
            ->first();

        // Jika affiliate tidak ditemukan, redirect atau tampilkan error
        if (!$affiliate) {
            return redirect()->back()->with('error', 'Data affiliate tidak ditemukan');
        }

        // Ambil semua komisi untuk affiliate ini dengan eager load perumahan
        $commissions = AffiliatesCommision::with('perumahan')
            ->where('affiliate_id', $affiliate->id)
            ->orderBy('bulan', 'desc')
            ->paginate(6);

        $totalUnit = AffiliatesCommision::where('affiliate_id',$affiliate->id)
            ->distinct()
            ->count('perumahan_id');
        return view('client.component.DataView.affiliate', compact('affiliate', 'user', 'commissions','totalUnit'));
    }




}
