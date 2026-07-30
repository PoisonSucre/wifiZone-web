<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Vendeur;
use App\Models\Withdrawal;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalVendeurs = 0;
    public int $vendeursActifs = 0;
    public int $vendeursSuspendus = 0;
    public int $vendeursEnAttente = 0;
    public int $totalTickets = 0;
    public int $ticketsVendus = 0;
    public float $totalRevenus = 0;
    public float $totalCommission = 0;
    public float $totalRetraits = 0;
    public int $nbRetraitsEnCours = 0;
    public float $montantRetraitsEnCours = 0;
    public array $derniersVendeurs = [];
    public array $dernieresTransactions = [];
    public array $vendeursEvolution = [];
    public array $actifsEvolution = [];
    public array $suspendusEvolution = [];
    public array $attenteEvolution = [];
    public array $ticketsEvolution = [];
    public array $vendusEvolution = [];
    public array $revenusEvolution = [];
    public array $commissionEvolution = [];
    public array $retraitsEvolution = [];
    public array $chartLabels = [];
    public array $chartRevenus = [];
    public array $chartCommissions = [];

    public function mount(): void
    {
        $this->totalVendeurs = Vendeur::count();
        $this->vendeursActifs = Vendeur::active()->count();
        $this->vendeursSuspendus = Vendeur::where('statut', 'suspendu')->count();
        $this->vendeursEnAttente = Vendeur::pending()->count();
        $this->totalTickets = Ticket::count();
        $this->ticketsVendus = Ticket::sold()->count();
        $this->totalRevenus = Transaction::completed()->sum('montant') ?? 0;
        $this->totalCommission = Transaction::completed()->sum('commission') ?? 0;
        $this->totalRetraits = Withdrawal::whereIn('statut', ['paid', 'approved'])->sum('montant_net') ?? 0;

        $pending = Withdrawal::pending();
        $this->nbRetraitsEnCours = $pending->count();
        $this->montantRetraitsEnCours = $pending->sum('montant_net') ?? 0;

        $this->derniersVendeurs = Vendeur::orderByDesc('date_inscription')->limit(5)->get()->map(function ($vendeur) {
                return $vendeur->makeHidden(['password', 'remember_token'])->toArray();
            })->toArray();

        $this->dernieresTransactions = Transaction::with('vendeur')
            ->orderByDesc('date_creation')->limit(5)->get()->toArray();

        $this->computeEvolutions();
    }

    private function computeEvolutions(): void
    {
        $dates = collect(range(6, 0))->map(fn ($d) => now()->subDays($d)->format('Y-m-d'));
        $this->chartLabels = $dates->map(fn ($d) => Carbon::parse($d)->format('d/m'))->toArray();

        $startDate = now()->subDays(6)->startOfDay();

        // Vendeurs — 1 grouped query
        $vendeursBefore = Vendeur::where('date_inscription', '<', $startDate)->count();
        $vendeursActifsBefore = Vendeur::where('statut', 'actif')
            ->where('date_inscription', '<', $startDate)->count();
        $vendeursSuspendusBefore = Vendeur::where('statut', 'suspendu')
            ->where('date_inscription', '<', $startDate)->count();
        $vendeursAttenteBefore = Vendeur::where('statut', 'en_attente')
            ->where('date_inscription', '<', $startDate)->count();

        $vendeursDaily = Vendeur::where('date_inscription', '>=', $startDate)
            ->selectRaw('DATE(date_inscription) as date')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("COUNT(CASE WHEN statut = 'actif' THEN 1 END) as actifs")
            ->selectRaw("COUNT(CASE WHEN statut = 'suspendu' THEN 1 END) as suspendus")
            ->selectRaw("COUNT(CASE WHEN statut = 'en_attente' THEN 1 END) as en_attente")
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $vTotal = $vendeursBefore;
        $aTotal = $vendeursActifsBefore;
        $sTotal = $vendeursSuspendusBefore;
        $eTotal = $vendeursAttenteBefore;

        foreach ($dates as $date) {
            $day = $vendeursDaily[$date] ?? null;
            $vTotal += $day->total ?? 0;
            $aTotal += $day->actifs ?? 0;
            $sTotal += $day->suspendus ?? 0;
            $eTotal += $day->en_attente ?? 0;
            $this->vendeursEvolution[] = $vTotal;
            $this->actifsEvolution[] = $aTotal;
            $this->suspendusEvolution[] = $sTotal;
            $this->attenteEvolution[] = $eTotal;
        }

        // Tickets — 1 grouped query
        $ticketsBefore = Ticket::where('date_creation', '<', $startDate)->count();
        $ticketsVendusBefore = Ticket::where('status', 'vendu')->where('date_creation', '<', $startDate)->count();

        $ticketsDaily = Ticket::where('date_creation', '>=', $startDate)
            ->selectRaw('DATE(date_creation) as date')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("COUNT(CASE WHEN status = 'vendu' THEN 1 END) as vendus")
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $tTotal = $ticketsBefore;
        $vTotal = $ticketsVendusBefore;

        foreach ($dates as $date) {
            $day = $ticketsDaily[$date] ?? null;
            $tTotal += $day->total ?? 0;
            $vTotal += $day->vendus ?? 0;
            $this->ticketsEvolution[] = $tTotal;
            $this->vendusEvolution[] = $vTotal;
        }

        // Transactions — 1 grouped query
        $revBefore = Transaction::where('statut', 'completed')
            ->where('date_creation', '<', $startDate)->sum('montant') ?? 0;
        $commBefore = Transaction::where('statut', 'completed')
            ->where('date_creation', '<', $startDate)->sum('commission') ?? 0;

        $transactionsDaily = Transaction::where('statut', 'completed')
            ->where('date_creation', '>=', $startDate)
            ->selectRaw('DATE(date_creation) as date')
            ->selectRaw('COALESCE(SUM(montant), 0) as montant')
            ->selectRaw('COALESCE(SUM(commission), 0) as commission')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $rTotal = $revBefore;
        $cTotal = $commBefore;

        foreach ($dates as $date) {
            $day = $transactionsDaily[$date] ?? null;
            $rTotal += $day->montant ?? 0;
            $cTotal += $day->commission ?? 0;
            $this->revenusEvolution[] = (int) $rTotal;
            $this->commissionEvolution[] = (int) $cTotal;
        }

        // Retraits — 1 grouped query
        $retraitsBefore = Withdrawal::where('date_creation', '<', $startDate)->count();

        $retraitsDaily = Withdrawal::where('date_creation', '>=', $startDate)
            ->selectRaw('DATE(date_creation) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $wTotal = $retraitsBefore;

        foreach ($dates as $date) {
            $day = $retraitsDaily[$date] ?? null;
            $wTotal += $day->total ?? 0;
            $this->retraitsEvolution[] = $wTotal;
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
