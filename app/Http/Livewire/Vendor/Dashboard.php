<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Services\LigdiCashService;
use App\Services\HotspotService;
use App\Services\TicketService;
use Livewire\Component;
use App\Http\Livewire\Vendor\Concerns\ChecksPendingPayments;

class Dashboard extends Component
{
    use ChecksPendingPayments;
    public int $totalVendus = 0;
    public int $totalDispo = 0;
    public float $totalRevenus = 0;
    public float $dejaRetire = 0;
    public float $revenusAujourdhui = 0;
    public float $commissionPct = 0;
    public float $soldeDisponible = 0;
    public float $soldeNet = 0;
    public array $stuckTransactions = [];
    public array $recentSales = [];
    public array $chartLabels = [];
    public array $chartData = [];
    public array $chartDatasets = [];
    public array $dispoParForfait = [];

    public array $revenusEvolution = [];
    public array $vendusEvolution = [];
    public array $dispoEvolution = [];
    public array $retraitsEvolution = [];
    public array $soldeEvolution = [];

    public function mount(): void
    {
        $vendeur = auth()->user();

        $this->totalVendus = $vendeur->tickets()->sold()->count();
        $this->totalDispo = $vendeur->tickets()->available()->count();
        $this->totalRevenus = $vendeur->transactions()->completed()->where('type', 'ticket')->sum('montant') ?? 0;
        $this->dejaRetire = $vendeur->withdrawals()->whereIn('statut', ['pending', 'approved', 'paid'])->sum('montant_brut') ?? 0;
        $this->revenusAujourdhui = $vendeur->transactions()->completed()
            ->where('type', 'ticket')
            ->whereDate('date_creation', today())->sum('montant') ?? 0;

        $this->commissionPct = $vendeur->commission_pct ?? config('platform.commission_pct', 10);
        $this->soldeDisponible = app(HotspotService::class)->soldeDisponible($vendeur);
        $this->soldeNet = $this->soldeDisponible * (1 - $this->commissionPct / 100);

        $this->stuckTransactions = Transaction::where('vendeur_id', $vendeur->id)
            ->where('statut', 'completed')
            ->where('type', 'ticket')
            ->whereNull('ticket_id')
            ->orderByDesc('date_creation')
            ->limit(20)
            ->select('id', 'statut', 'phone_number', 'montant', 'date_creation', 'token', 'ticket_id')
            ->get()
            ->toArray();

        $this->recentSales = Transaction::where('transactions.vendeur_id', $vendeur->id)
            ->where('transactions.statut', 'completed')
            ->leftJoin('ticket', 'transactions.ticket_id', '=', 'ticket.id')
            ->select('transactions.*', 'ticket.user', 'ticket.forfait')
            ->orderByDesc('transactions.date_creation')
            ->limit(10)
            ->get()
            ->toArray();

        $this->buildChart($vendeur);
        $this->computeEvolutions($vendeur);
    }

    private function buildChart($vendeur): void
    {
        $chart = Transaction::where('vendeur_id', $vendeur->id)
            ->where('statut', 'completed')
            ->where('type', 'ticket')
            ->where('date_creation', '>=', now()->subDays(30))
            ->selectRaw('DATE(date_creation) as jour, SUM(montant) as total')
            ->groupBy('jour')
            ->orderBy('jour')
            ->get();

        $this->chartLabels = $chart->pluck('jour')->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d/m'))->toArray();
        $this->chartData = $chart->pluck('total')->toArray();

        $this->dispoParForfait = Ticket::where('vendeur_id', $vendeur->id)
            ->available()
            ->selectRaw('forfait, COUNT(*) as nb')
            ->groupBy('forfait')
            ->orderByDesc('nb')
            ->get()
            ->toArray();

        $byForfait = Transaction::where('transactions.vendeur_id', $vendeur->id)
            ->where('transactions.statut', 'completed')
            ->where('transactions.date_creation', '>=', now()->subDays(30))
            ->leftJoin('ticket', 'transactions.ticket_id', '=', 'ticket.id')
            ->selectRaw('DATE(transactions.date_creation) as jour, ticket.forfait, SUM(transactions.montant) as total')
            ->groupBy('jour', 'ticket.forfait')
            ->get()
            ->groupBy('forfait');

        $allDays = $chart->pluck('jour')->map(fn ($d) => (string) $d)->toArray();

        $borderColors = ['#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#3B82F6', '#EC4899'];
        $bgColors = [
            'rgba(16,185,129,0.08)', 'rgba(139,92,246,0.08)', 'rgba(245,158,11,0.08)',
            'rgba(239,68,68,0.08)', 'rgba(59,130,246,0.08)', 'rgba(236,72,153,0.08)',
        ];
        $pointStyles = ['circle', 'rect', 'triangle', 'rectRounded', 'star', 'cross'];

        $sorted = $byForfait->sortByDesc(fn ($rows) => $rows->sum('total'));
        $top = $sorted->take(5);
        $others = $sorted->skip(5);

        $i = 0;
        foreach ($top as $forfaitName => $rows) {
            $label = $forfaitName ?: 'N/A';
            $byDay = $rows->pluck('total', 'jour')->toArray();
            $data = array_map(fn ($day) => $byDay[$day] ?? 0, $allDays);
            $this->chartDatasets[] = [
                'label' => $label,
                'data' => $data,
                'borderColor' => $borderColors[$i],
                'backgroundColor' => $bgColors[$i],
                'tension' => 0.4,
                'borderWidth' => 2.5,
                'pointRadius' => 3,
                'pointHoverRadius' => 6,
                'pointBackgroundColor' => $borderColors[$i],
                'pointStyle' => $pointStyles[$i],
                'fill' => true,
            ];
            $i++;
        }

        if ($others->isNotEmpty()) {
            $othersData = array_fill(0, count($allDays), 0);
            foreach ($others as $rows) {
                $byDay = $rows->pluck('total', 'jour')->toArray();
                foreach ($allDays as $idx => $day) {
                    $othersData[$idx] += $byDay[$day] ?? 0;
                }
            }
            $this->chartDatasets[] = [
                'label' => 'Autres',
                'data' => $othersData,
                'borderColor' => '#9CA3AF',
                'backgroundColor' => 'rgba(156,163,175,0.06)',
                'tension' => 0.4,
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 5,
                'pointBackgroundColor' => '#9CA3AF',
                'pointStyle' => 'line',
                'borderDash' => [5, 5],
                'fill' => true,
            ];
        }
    }

    private function computeEvolutions($vendeur): void
    {
        $dates = collect(range(6, 0))->map(fn ($d) => now()->subDays($d)->format('Y-m-d'));
        $startDate = now()->subDays(6)->startOfDay();

        $this->revenusEvolution = [];
        $this->vendusEvolution = [];
        $this->dispoEvolution = [];
        $this->retraitsEvolution = [];
        $this->soldeEvolution = [];

        // Tickets — 1 grouped query (vendus cumul, dispo cumul)
        $ticketsVendusBefore = Ticket::where('vendeur_id', $vendeur->id)
            ->where('status', 'vendu')->where('date_creation', '<', $startDate)->count();
        $ticketsDispoBefore = Ticket::where('vendeur_id', $vendeur->id)
            ->where('status', 'disponible')->where('date_creation', '<', $startDate)->count();

        $ticketsDaily = Ticket::where('vendeur_id', $vendeur->id)
            ->where('date_creation', '>=', $startDate)
            ->selectRaw('DATE(date_creation) as date')
            ->selectRaw("COUNT(CASE WHEN status = 'vendu' THEN 1 END) as vendus")
            ->selectRaw("COUNT(CASE WHEN status = 'disponible' THEN 1 END) as disponibles")
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $vendTotal = $ticketsVendusBefore;
        $dispoTotal = $ticketsDispoBefore;

        // Transactions — 1 grouped query (revenus daily, non-cumul)
        $transactionsDaily = Transaction::where('vendeur_id', $vendeur->id)
            ->where('statut', 'completed')
            ->where('type', 'ticket')
            ->where('date_creation', '>=', $startDate)
            ->selectRaw('DATE(date_creation) as date, COALESCE(SUM(montant), 0) as montant')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Withdrawals — 1 grouped query (retraits daily, non-cumul)
        $retraitsDaily = Withdrawal::where('vendeur_id', $vendeur->id)
            ->whereIn('statut', ['paid', 'approved'])
            ->where('date_creation', '>=', $startDate)
            ->selectRaw('DATE(date_creation) as date, COALESCE(SUM(montant_brut), 0) as montant')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $cumulRevenus = 0;
        $cumulRetraits = 0;

        foreach ($dates as $date) {
            $rev = (int) ($transactionsDaily[$date]->montant ?? 0);
            $ret = (int) ($retraitsDaily[$date]->montant ?? 0);
            $dayTickets = $ticketsDaily[$date] ?? null;

            $vendTotal += $dayTickets->vendus ?? 0;
            $dispoTotal += $dayTickets->disponibles ?? 0;
            $cumulRevenus += $rev;
            $cumulRetraits += $ret;

            $this->revenusEvolution[] = $rev;
            $this->vendusEvolution[] = $vendTotal;
            $this->dispoEvolution[] = $dispoTotal;
            $this->retraitsEvolution[] = $ret;
            $this->soldeEvolution[] = max(0, $cumulRevenus - $cumulRetraits);
        }
    }

    public function refreshStuck(): void
    {
        $vendeur = auth()->user();
        $this->stuckTransactions = Transaction::where('vendeur_id', $vendeur->id)
            ->where('statut', 'completed')
            ->where('type', 'ticket')
            ->whereNull('ticket_id')
            ->orderByDesc('date_creation')
            ->limit(20)
            ->select('id', 'statut', 'phone_number', 'montant', 'date_creation', 'token', 'ticket_id')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.vendor.dashboard');
    }
}
