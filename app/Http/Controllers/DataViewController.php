<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
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
        $affiliate = Affiliate::where('user_id', $user->id)->first();

        return view('client.component.DataView.affiliate', compact('affiliate', 'user'));
    }




}
