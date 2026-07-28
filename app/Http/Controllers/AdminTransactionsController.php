<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class AdminTransactionsController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('ticket', 'vendeur');

        if ($request->filled('vendeur_id')) {
            $query->where('vendeur_id', $request->vendeur_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $transactions = $query->orderByDesc('date_creation')->limit(200)->get();
        $vendeurs = Vendeur::select('id', 'nom', 'prenom')->orderBy('nom')->get();

        return view('admin.transactions', compact('transactions', 'vendeurs'));
    }
}
