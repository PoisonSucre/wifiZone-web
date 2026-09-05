<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use App\Models\Hotspot;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show(Request $request, int $id)
    {
        $vendeur = Vendeur::active()->findOrFail($id);

        $hsId = (int) $request->query('hotspot', 0);
        $hotspot = $hsId > 0 ? Hotspot::where('id', $hsId)->where('vendeur_id', $vendeur->id)->first() : null;

        if ($hotspot) {
            $vendeur->couleur = $hotspot->couleur;
            $vendeur->couleur_top = $hotspot->couleur_top;
            $vendeur->nom_portail = $hotspot->nom_portail;
            $vendeur->message_bienvenue = $hotspot->message_bienvenue;
            $vendeur->logo = $hotspot->logo;
            $forfaits = Forfait::where('hotspot_id', $hotspot->id)->active()->ordered()->get();
        } else {
            $forfaits = $vendeur->forfaits()->active()->ordered()->get();
        }

        return view('shop.template.preview', compact('vendeur', 'forfaits', 'hotspot') + ['hideLogin' => true]);
    }
}
