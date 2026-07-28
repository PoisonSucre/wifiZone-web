<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show(Request $request, int $id)
    {
        $vendeur = Vendeur::active()->findOrFail($id);
        $forfaits = $vendeur->forfaits()->active()->ordered()->get();

        return view('shop.template.preview', compact('vendeur', 'forfaits'));
    }
}
