<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Affiliate;
use Illuminate\Support\Str;
use App\Models\Perumahan;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    //
    public function login()
    {
        return view('login.login');
    }

    public function register()
    {
        $perumahan= Perumahan::all();
        return view('login.register', compact('perumahan'));
    }

   public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        Log::info('User logged in:', ['role' => $user->role, 'email' => $user->email]); // Debug log

        switch ($user->role) {
            case 'admin':
            case 'sales':
            case 'salesAdmin':
                return redirect('/dashboard');

            case 'agent':
                return redirect('/viewAgent');

            case 'affiliate':
                Log::info('Redirecting to viewAffiliate');
                return redirect('/viewAffiliate');

            default:
                Auth::logout();
                return back()->with('loginError', 'Role tidak dikenali.');
        }
    }


        return back()->with('loginError', 'Login Failed!');
    }


   public function registerAffiliate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'exists:perumahan,id',
            'referrer_code' => 'nullable|string|max:20', // ← TAMBAH INI
        ]);

        // ← TAMBAH BAGIAN INI (validasi kode referral)
        $referrerType = null;
        $referrerId = null;
        $referrerName = null;

        if (!empty($validated['referrer_code'])) {
            $referrer = User::where('code', strtoupper($validated['referrer_code']))
                        ->whereIn('role', ['sales', 'salesAdmin'])
                        ->first();

            if ($referrer) {
                $referrerType = User::class;
                $referrerId = $referrer->id;
                $referrerName = $referrer->name;
            } else {
                return back()
                    ->withInput()
                    ->withErrors(['referrer_code' => 'Kode referral tidak valid']);
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'affiliate',
        ]);

        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'code' => strtoupper(Str::random(6)),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'joined_at' => now(),
            'referrer_type' => $referrerType, // ← TAMBAH INI
            'referrer_id' => $referrerId,     // ← TAMBAH INI
        ]);

        if (isset($validated['perumahan_id'])) {
            $affiliate->perumahan_id = json_encode($validated['perumahan_id']);
            $affiliate->save();
        }

        $successMessage = $referrerName
            ? "Pendaftaran berhasil! Anda terhubung dengan Sales: {$referrerName}. Silakan login."
            : "Pendaftaran berhasil! Silakan login.";

        return redirect('/loginUser')->with('success', $successMessage);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
