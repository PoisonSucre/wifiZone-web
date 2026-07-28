<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use App\Models\Forfait;

class LandingController extends Controller
{
    public function index()
    {
        $vendeursActifs = Vendeur::active()->count();
        $ticketsVendus = \App\Models\Ticket::sold()->count();
        $forfaits = Forfait::active()->ordered()->limit(5)->get();

        return view('pages.landing', compact('vendeursActifs', 'ticketsVendus', 'forfaits'));
    }
}
