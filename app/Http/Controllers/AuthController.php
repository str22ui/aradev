<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('login.login');
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

            if ($user->role == 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role == 'sales') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role == 'salesAdmin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role == 'ownerNaputa') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role == 'ownerGevana') {
                return redirect()->intended('/dashboard');
            }
        }
        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->Session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
