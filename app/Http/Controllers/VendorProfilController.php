<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorProfilController extends Controller
{
    public function index(Request $request)
    {
        $vendeur = Auth::user();

        if ($request->isMethod('post')) {
            $request->validate([
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
                'telephone' => 'required|string|max:20',
                'adresse' => 'nullable|string|max:255',
                'ville' => 'nullable|string|max:100',
                'new_password' => 'nullable|string|min:6',
                'confirm_password' => 'nullable|string|same:new_password',
            ]);

            $data = [
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'ville' => $request->ville,
            ];

            if ($request->filled('new_password')) {
                $data['password'] = $request->new_password;
            }

            $vendeur->update($data);
            Auth::setUser($vendeur->fresh());

            return redirect()->route('vendor.profil')->with('success', 'Profil mis à jour.');
        }

        return view('vendor.profil', compact('vendeur'));
    }
}
