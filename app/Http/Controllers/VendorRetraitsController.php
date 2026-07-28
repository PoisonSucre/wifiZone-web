<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Vendeur;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalRequestedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorRetraitsController extends Controller
{
    public function index(Request $request)
    {
        $vendeur = Auth::user();

        $totalRevenus = $vendeur->transactions()->completed()->sum('montant') ?? 0;
        $dejaRetire = $vendeur->withdrawals()->whereIn('statut', ['approved', 'paid'])->sum('montant_brut') ?? 0;
        $commissionPct = $vendeur->commission_pct ?? config('platform.commission_pct', 10);
        $soldeDisponible = max(0, $totalRevenus - $dejaRetire);
        $soldeNet = $soldeDisponible * (1 - $commissionPct / 100);

        if ($request->isMethod('post')) {
            $request->validate([
                'montant' => 'required|integer|min:1',
                'phone_number' => 'required|string|max:20',
            ]);

            $montant = (int) $request->montant;
            if ($montant > $soldeDisponible) {
                return back()->withErrors(['montant' => 'Solde insuffisant.'])->withInput();
            }

            $comm = $montant * ($commissionPct / 100);
            $net = $montant - $comm;

            Withdrawal::create([
                'vendeur_id' => $vendeur->id,
                'montant_brut' => $montant,
                'commission_pct' => $commissionPct,
                'montant_commission' => $comm,
                'montant_net' => $net,
                'phone_number' => $request->phone_number,
            ]);

            try {
                $adminEmail = Setting::get('admin_email', Vendeur::where('is_admin', true)->value('email'));
                $admin = Vendeur::where('email', $adminEmail)->where('is_admin', true)->first();
                if ($admin) {
                    $withdrawal = $vendeur->withdrawals()->latest()->first();
                    $admin->notify(new WithdrawalRequestedNotification($withdrawal));
                }
            } catch (\Exception $e) {
                \Log::error('Erreur notification retrait demandé', ['error' => $e->getMessage()]);
            }

            return redirect()->route('vendor.retraits')->with('success', 'Demande de retrait soumise.');
        }

        $retraits = $vendeur->withdrawals()->orderByDesc('date_creation')->get();

        return view('vendor.retraits', compact('vendeur', 'totalRevenus', 'dejaRetire', 'commissionPct', 'soldeDisponible', 'soldeNet', 'retraits'));
    }
}
