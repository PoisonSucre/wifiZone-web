<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class AdminVendeursController extends Controller
{
    public function index(Request $request)
    {
        $adminEmail = Setting::get('admin_email', Vendeur::where('is_admin', true)->value('email'));

        $query = Vendeur::where('email', '!=', $adminEmail)
            ->withCount([
                'tickets as nb_vendus' => fn ($q) => $q->where('status', 'vendu'),
                'tickets as nb_dispo' => fn ($q) => $q->where('status', 'disponible'),
            ])
            ->withSum(['transactions as revenus' => fn ($q) => $q->where('statut', 'completed')], 'montant');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $vendeurs = $query->orderByDesc('date_inscription')->paginate(20);

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            match ($action) {
                'activate' => $this->activate($request),
                'suspend' => $this->suspend($request),
                'delete' => $this->delete($request),
                'add' => $this->add($request),
                'update_commission' => $this->updateCommission($request),
                default => null,
            };

            return redirect()->back()->with('success', 'Action effectuée.');
        }

        return view('admin.vendeurs', compact('vendeurs'));
    }

    private function activate(Request $request): void
    {
        Vendeur::where('id', $request->vendeur_id)->update(['statut' => 'actif']);
    }

    private function suspend(Request $request): void
    {
        Vendeur::where('id', $request->vendeur_id)->update(['statut' => 'suspendu']);
    }

    private function delete(Request $request): void
    {
        Vendeur::where('id', $request->vendeur_id)->delete();
    }

    private function add(Request $request): void
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:vendeurs,email',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'commission_pct' => 'nullable|numeric|min:0|max:100',
        ]);

        Vendeur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $request->password,
            'statut' => 'actif',
            'commission_pct' => $request->commission_pct ?? config('platform.commission_pct', 10),
            'card_number' => Vendeur::generateCardNumber(),
        ]);
    }

    private function updateCommission(Request $request): void
    {
        $request->validate([
            'vendeur_id' => 'required|exists:vendeurs,id',
            'commission_pct' => 'required|numeric|min:0|max:100',
        ]);

        Vendeur::where('id', $request->vendeur_id)
            ->update(['commission_pct' => $request->commission_pct]);
    }
}
