<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminLog;
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

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            AdminLog::create([
                'admin_id' => null,
                'action' => 'admin_login_failed',
                'target_type' => 'admin',
                'target_id' => null,
                'details' => "Tentative de connexion échouée pour {$request->email}",
                'ip' => $request->ip(),
            ]);

            return back()->withErrors(['email' => 'Identifiants administrateur incorrects.'])->withInput($request->only('email'));
        }

        Auth::guard('admin')->login($admin);

        $request->session()->regenerate();

        AdminLog::create([
            'admin_id' => $admin->id,
            'action' => 'admin_login',
            'target_type' => 'admin',
            'target_id' => $admin->id,
            'details' => "Connexion de {$admin->email}",
            'ip' => $request->ip(),
        ]);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $admin = auth('admin')->user();

        if ($admin) {
            AdminLog::create([
                'admin_id' => $admin->id,
                'action' => 'admin_logout',
                'target_type' => 'admin',
                'target_id' => $admin->id,
                'details' => "Déconnexion de {$admin->email}",
                'ip' => $request->ip(),
            ]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
