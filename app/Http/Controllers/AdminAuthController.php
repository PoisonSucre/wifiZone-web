<?php

namespace App\Http\Controllers;

use App\Mail\AdminSetPasswordMail;
use App\Models\Admin;
use App\Models\AdminLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $request->session()->forget('url.intended');

        AdminLog::create([
            'admin_id' => $admin->id,
            'action' => 'admin_login',
            'target_type' => 'admin',
            'target_id' => $admin->id,
            'details' => "Connexion de {$admin->email}",
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.dashboard');
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

    public function showForgotPasswordForm()
    {
        return view('auth.admin-forgot-password');
    }

    public function sendSetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Aucun compte administrateur associé à cette adresse email.']);
        }

        $this->issuePasswordReset($admin);

        return back()->with('success', 'Un email vous a été envoyé pour définir votre mot de passe.');
    }

    public function showSetPasswordForm(Request $request, string $token)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('admin.forgot-password');
        }

        return view('auth.admin-set-password', ['token' => $token, 'email' => $email]);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !$admin->password_reset_token || !Hash::check($request->token, $admin->password_reset_token)) {
            return back()->withErrors(['email' => 'Ce lien est invalide ou a déjà été utilisé.']);
        }

        if (Carbon::parse($admin->password_reset_token_expires_at)->isPast()) {
            $admin->update(['password_reset_token' => null, 'password_reset_token_expires_at' => null]);
            return back()->withErrors(['email' => 'Ce lien a expiré. Demandez un nouveau lien.']);
        }

        $admin->update([
            'password' => $request->password,
            'password_reset_token' => null,
            'password_reset_token_expires_at' => null,
        ]);

        AdminLog::create([
            'admin_id' => $admin->id,
            'action' => 'update_security',
            'target_type' => 'admin',
            'target_id' => $admin->id,
            'details' => "Mot de passe défini via email pour {$admin->email}",
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.login')->with('success', 'Votre mot de passe a été défini. Vous pouvez maintenant vous connecter.');
    }

    public function issuePasswordReset(Admin $admin): string
    {
        $token = Str::random(64);

        $admin->update([
            'password_reset_token' => Hash::make($token),
            'password_reset_token_expires_at' => Carbon::now()->addMinutes(30),
        ]);

        $setPasswordUrl = url('/raider/reset-password/' . $token . '?email=' . urlencode($admin->email));

        try {
            Mail::to($admin->email)->send(new AdminSetPasswordMail($admin, $setPasswordUrl));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email admin set password', ['email' => $admin->email, 'error' => $e->getMessage()]);
        }

        return $token;
    }
}
