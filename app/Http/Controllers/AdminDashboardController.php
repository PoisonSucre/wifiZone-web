<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Vendeur;
use App\Models\Withdrawal;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $adminEmail = Setting::get('admin_email', Vendeur::where('is_admin', true)->value('email'));

        $totalVendeurs = Vendeur::where('email', '!=', $adminEmail)->count();
        $vendeursActifs = Vendeur::active()->where('email', '!=', $adminEmail)->count();
        $vendeursEnAttente = Vendeur::pending()->count();
        $totalTickets = Ticket::count();
        $ticketsVendus = Ticket::sold()->count();
        $totalRevenus = Transaction::completed()->sum('montant') ?? 0;
        $totalCommission = Transaction::completed()->sum('commission') ?? 0;

        $pendingWithdrawals = Withdrawal::pending();
        $nbRetraitsEnCours = $pendingWithdrawals->count();
        $montantRetraitsEnCours = $pendingWithdrawals->sum('montant_net') ?? 0;

        $derniersVendeurs = Vendeur::where('email', '!=', $adminEmail)
            ->orderByDesc('date_inscription')
            ->limit(5)
            ->get();

        $dernièresTransactions = Transaction::with('ticket', 'vendeur')
            ->orderByDesc('date_creation')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalVendeurs', 'vendeursActifs', 'vendeursEnAttente',
            'totalTickets', 'ticketsVendus', 'totalRevenus', 'totalCommission',
            'nbRetraitsEnCours', 'montantRetraitsEnCours',
            'derniersVendeurs', 'dernièresTransactions'
        ));
    }
}
