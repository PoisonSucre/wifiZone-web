<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $vendeur = Vendeur::where('email', $request->email)->where('is_admin', true)->first();

        if (!$vendeur || !Hash::check($request->password, $vendeur->password)) {
            return back()->withErrors(['email' => 'Identifiants administrateur incorrects.'])->withInput($request->only('email'));
        }

        if ($vendeur->statut === 'suspendu') {
            return back()->withErrors(['email' => 'Votre compte administrateur est suspendu.'])->withInput($request->only('email'));
        }

        Auth::guard('admin')->login($vendeur);
        $vendeur->update(['last_login' => now()]);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
