<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class AdminTicketsController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('vendeur');

        if ($request->filled('vendeur_id')) {
            $query->where('vendeur_id', $request->vendeur_id);
        }

        if ($request->filled('statut')) {
            $query->where('status', $request->statut);
        }

        $tickets = $query->orderByDesc('id')->limit(500)->paginate(50);
        $vendeurs = Vendeur::select('id', 'nom', 'prenom')->orderBy('nom')->get();

        return view('admin.tickets', compact('tickets', 'vendeurs'));
    }

    public function create(Request $request)
    {
        $vendeur = Vendeur::where('is_admin', true)->first();
        if (!$vendeur) {
            return redirect()->route('admin.dashboard')->with('error', 'Aucun administrateur trouvé. Exécutez : php artisan admin:create');
        }

        $forfaits = $vendeur->forfaits()->active()->ordered()->get();

        if ($request->isMethod('post')) {
            $mode = $request->input('mode', 'single');

            if ($mode === 'batch') {
                $request->validate([
                    'prefix' => 'required|string|max:20',
                    'start_number' => 'required|integer|min:0',
                    'count' => 'required|integer|min:1|max:500',
                    'pass_length' => 'required|integer|min:4|max:32',
                    'forfait_id' => 'required|exists:vendor_forfaits,id',
                ]);

                $forfait = \App\Models\Forfait::find($request->forfait_id);
                $count = min(500, $request->count);
                $created = 0;

                for ($i = 0; $i < $count; $i++) {
                    $num = $request->start_number + $i;
                    $user = $request->prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
                    $pass = bin2hex(random_bytes(intdiv($request->pass_length, 2) + 1));
                    $pass = substr($pass, 0, $request->pass_length);

                    Ticket::create([
                        'vendeur_id' => $vendeur->id,
                        'user' => $user,
                        'password' => $pass,
                        'forfait' => $forfait->label,
                        'montant' => $forfait->montant,
                        'source' => 'manual',
                    ]);
                    $created++;
                }

                return redirect()->route('admin.tickets.create')->with('success', "{$created} tickets créés.");
            } else {
                $request->validate([
                    'user' => 'required|string|max:255',
                    'ticket_password' => 'required|string|max:255',
                    'forfait_id' => 'required|exists:vendor_forfaits,id',
                ]);

                $forfait = \App\Models\Forfait::find($request->forfait_id);

                Ticket::create([
                    'vendeur_id' => $vendeur->id,
                    'user' => $request->user,
                    'password' => $request->ticket_password,
                    'forfait' => $forfait->label,
                    'montant' => $forfait->montant,
                    'source' => 'manual',
                ]);

                return redirect()->route('admin.tickets.create')->with('success', 'Ticket créé.');
            }
        }

        return view('admin.ajouter-ticket', compact('vendeur', 'forfaits'));
    }
}
