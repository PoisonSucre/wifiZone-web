<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendeur = Auth::user();

        $totalVendus = $vendeur->tickets()->sold()->count();
        $totalDispo = $vendeur->tickets()->available()->count();
        $totalRevenus = $vendeur->transactions()->completed()->sum('montant') ?? 0;
        $dejaRetire = $vendeur->withdrawals()->whereIn('statut', ['approved', 'paid'])->sum('montant_brut') ?? 0;
        $revenusAujourdhui = $vendeur->transactions()->completed()
            ->whereDate('date_creation', today())
            ->sum('montant') ?? 0;

        $commissionPct = $vendeur->commission_pct ?? config('platform.commission_pct', 10);
        $soldeDisponible = max(0, $totalRevenus - $dejaRetire);
        $soldeNet = $soldeDisponible * (1 - $commissionPct / 100);

        $recentSales = Transaction::where('vendeur_id', $vendeur->id)
            ->leftJoin('ticket', 'transactions.ticket_id', '=', 'ticket.id')
            ->select('transactions.*', 'ticket.user', 'ticket.forfait')
            ->orderByDesc('transactions.date_creation')
            ->limit(10)
            ->get();

        $chartData = Transaction::where('vendeur_id', $vendeur->id)
            ->where('statut', 'completed')
            ->where('date_creation', '>=', now()->subDays(30))
            ->selectRaw('DATE(date_creation) as jour, SUM(montant) as total')
            ->groupBy('jour')
            ->orderBy('jour')
            ->get();

        return view('vendor.dashboard', compact(
            'vendeur', 'totalVendus', 'totalDispo', 'totalRevenus',
            'dejaRetire', 'revenusAujourdhui', 'commissionPct',
            'soldeDisponible', 'soldeNet', 'recentSales', 'chartData'
        ));
    }
}
