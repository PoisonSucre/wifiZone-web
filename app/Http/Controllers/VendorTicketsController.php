<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorTicketsController extends Controller
{
    public function index(Request $request)
    {
        $vendeur = Auth::user();

        $query = Ticket::where('vendeur_id', $vendeur->id);

        if ($request->filled('filter') && $request->filter !== 'all') {
            $query->where('status', $request->filter);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user', 'like', "%{$search}%")
                  ->orWhere('forfait', 'like', "%{$search}%");
            });
        }

        $tickets = $query->orderByDesc('id')->paginate(50);

        $nbDispo = Ticket::where('vendeur_id', $vendeur->id)->available()->count();
        $nbVendus = Ticket::where('vendeur_id', $vendeur->id)->sold()->count();

        return view('vendor.tickets', compact('tickets', 'nbDispo', 'nbVendus'));
    }
}
