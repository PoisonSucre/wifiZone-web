<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $vendeur = Vendeur::where('email', $request->email)->first();

        if (!$vendeur) {
            return back()->withErrors(['email' => 'Aucun compte associé à cette adresse email.']);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = url('/auth/reset-password/' . $token . '?email=' . urlencode($request->email));

        try {
            Mail::to($request->email)->send(new ResetPasswordMail($vendeur, $resetUrl));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email reset password', ['email' => $request->email, 'error' => $e->getMessage()]);
        }

        return redirect()->route('vendor.forgot-password')->with('status', 'Un email de réinitialisation a été envoyé.');
    }

    public function showResetForm(Request $request, string $token)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('vendor.forgot-password');
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Ce lien de réinitialisation est invalide ou a expiré.']);
        }

        if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Ce lien de réinitialisation a expiré. Demandez un nouveau lien.']);
        }

        $vendeur = Vendeur::where('email', $request->email)->first();

        if (!$vendeur) {
            return back()->withErrors(['email' => 'Compte introuvable.']);
        }

        $vendeur->update(['password' => $request->password]);
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('vendor.login')->with('status', 'Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.');
    }
}
