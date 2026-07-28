<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorBoutiqueController extends Controller
{
    public function index(Request $request)
    {
        $vendeur = Auth::user();
        $forfaits = $vendeur->forfaits()->ordered()->get();

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            match ($action) {
                'update_shop' => $this->updateShop($request, $vendeur),
                'add_forfait' => $this->addForfait($request, $vendeur),
                'edit_forfait' => $this->editForfait($request, $vendeur),
                'delete_forfait' => $this->deleteForfait($request, $vendeur),
                'toggle_forfait' => $this->toggleForfait($request, $vendeur),
                default => null,
            };

            return redirect()->route('vendor.boutique')->with('success', 'Modifications enregistrées.');
        }

        return view('vendor.boutique', compact('vendeur', 'forfaits'));
    }

    private function updateShop(Request $request, Vendeur $vendeur): void
    {
        $request->validate([
            'couleur' => 'required|string|max:7',
            'message_bienvenue' => 'nullable|string',
        ]);

        $data = [
            'couleur' => $request->couleur,
            'message_bienvenue' => $request->message_bienvenue,
        ];

        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:jpeg,png,gif,webp|max:2048']);

            if ($vendeur->logo && file_exists(public_path($vendeur->logo))) {
                unlink(public_path($vendeur->logo));
            }

            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = 'logo_' . $vendeur->id . '.' . $ext;
            $file->move(public_path('assets/uploads/logos'), $filename);
            $data['logo'] = 'assets/uploads/logos/' . $filename;
        }

        $vendeur->update($data);
    }

    private function addForfait(Request $request, Vendeur $vendeur): void
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'montant' => 'required|integer|min:1',
            'duree_minutes' => 'required|integer|min:1',
        ]);

        $maxOrdre = $vendeur->forfaits()->max('ordre') ?? 0;

        $vendeur->forfaits()->create([
            'label' => $request->label,
            'montant' => $request->montant,
            'duree_minutes' => $request->duree_minutes,
            'ordre' => $maxOrdre + 1,
        ]);
    }

    private function editForfait(Request $request, Vendeur $vendeur): void
    {
        $request->validate([
            'forfait_id' => 'required|exists:vendor_forfaits,id',
            'label' => 'required|string|max:50',
            'montant' => 'required|integer|min:1',
            'duree_minutes' => 'required|integer|min:1',
        ]);

        $vendeur->forfaits()
            ->where('id', $request->forfait_id)
            ->update([
                'label' => $request->label,
                'montant' => $request->montant,
                'duree_minutes' => $request->duree_minutes,
            ]);
    }

    private function deleteForfait(Request $request, Vendeur $vendeur): void
    {
        $request->validate(['forfait_id' => 'required|exists:vendor_forfaits,id']);

        $vendeur->forfaits()->where('id', $request->forfait_id)->delete();
    }

    private function toggleForfait(Request $request, Vendeur $vendeur): void
    {
        $request->validate(['forfait_id' => 'required|exists:vendor_forfaits,id']);

        $forfait = $vendeur->forfaits()->where('id', $request->forfait_id)->first();
        $forfait->update(['actif' => !$forfait->actif]);
    }
}
