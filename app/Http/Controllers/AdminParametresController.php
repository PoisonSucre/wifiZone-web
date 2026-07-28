<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use App\Models\Setting;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminParametresController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'update_platform') {
                $request->validate([
                    'plateforme_nom' => 'required|string|max:100',
                    'plateforme_devise' => 'required|string|max:10',
                    'commission_pct' => 'required|numeric|min:0|max:100',
                ]);

                Setting::set('plateforme_nom', $request->plateforme_nom, 'Nom de la plateforme');
                Setting::set('plateforme_devise', $request->plateforme_devise, 'Devise utilisée');
                Setting::set('commission_pct', $request->commission_pct, 'Commission globale (%)');
            }

            if ($action === 'update_security') {
                $request->validate([
                    'admin_email' => 'required|email',
                    'admin_new_pass' => 'nullable|string|min:6',
                    'admin_confirm_pass' => 'nullable|string|same:admin_new_pass',
                ]);

                Setting::set('admin_email', $request->admin_email, 'Email admin');

                if ($request->filled('admin_new_pass')) {
                    Setting::set('admin_pass_hash', Hash::make($request->admin_new_pass), 'Hash du mot de passe admin');
                }
            }

            return redirect()->route('admin.parametres')->with('success', 'Paramètres mis à jour.');
        }

        $settings = Setting::allAsArray();

        return view('admin.parametres', compact('settings'));
    }
}
