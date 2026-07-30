<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalPaidNotification;
use App\Notifications\WithdrawalRejectedNotification;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class RetraitManager extends Component
{
    use WithPagination;

    public string $filterStatut = '';
    public bool $showRejectModal = false;
    public ?int $rejectingRetraitId = null;
    public string $rejectReason = '';
    public array $retraitsEvolution = [];
    public array $montantEvolution = [];

    public bool $showConfirm = false;
    public ?int $confirmingId = null;
    public string $confirmMessage = '';
    public string $confirmAction = '';
    public string $confirmButtonText = 'Confirmer';
    public string $confirmButtonClass = 'bg-emerald-600 hover:bg-emerald-700';

    public function openConfirm(string $action, int $id, string $message, string $btnText = 'Confirmer', string $btnClass = 'bg-emerald-600 hover:bg-emerald-700'): void
    {
        $this->confirmAction = $action;
        $this->confirmingId = $id;
        $this->confirmMessage = $message;
        $this->confirmButtonText = $btnText;
        $this->confirmButtonClass = $btnClass;
        $this->showConfirm = true;
    }

    public function closeConfirm(): void
    {
        $this->showConfirm = false;
        $this->confirmingId = null;
        $this->confirmMessage = '';
        $this->confirmAction = '';
    }

    public function executeConfirm(): void
    {
        $id = $this->confirmingId;
        $action = $this->confirmAction;
        $this->closeConfirm();
        match ($action) {
            'pay' => $this->pay($id),
            default => null,
        };
    }

    public function openRejectModal(int $id): void
    {
        $this->rejectingRetraitId = $id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function closeRejectModal(): void
    {
        $this->showRejectModal = false;
        $this->rejectingRetraitId = null;
        $this->rejectReason = '';
    }

    public function confirmReject(): void
    {
        $this->validate(['rejectReason' => 'required|string|min:3|max:500']);
        $withdrawal = Withdrawal::with('vendeur')->findOrFail($this->rejectingRetraitId);
        $withdrawal->update([
            'statut' => 'rejected',
            'note' => $this->rejectReason,
            'date_traitement' => now(),
            'traite_par' => auth()->id() ?? 0,
        ]);

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'reject_withdrawal',
            'target_type' => 'withdrawal',
            'target_id' => $withdrawal->id,
            'details' => "Retrait #{$withdrawal->id} rejeté: {$this->rejectReason}",
            'ip' => request()->ip(),
        ]);

        try {
            $withdrawal->vendeur->notify(new WithdrawalRejectedNotification($withdrawal));
        } catch (\Exception $e) {
            \Log::error('Erreur notification retrait rejeté', ['error' => $e->getMessage()]);
        }

        $this->closeRejectModal();
        session()->flash('success', 'Retrait rejeté.');
    }

    public function pay(int $id): void
    {
        $withdrawal = Withdrawal::with('vendeur')->findOrFail($id);
        $withdrawal->update([
            'statut' => 'paid',
            'date_traitement' => now(),
            'traite_par' => auth()->id() ?? 0,
        ]);

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'pay_withdrawal',
            'target_type' => 'withdrawal',
            'target_id' => $withdrawal->id,
            'details' => "Retrait #{$withdrawal->id} payé - {$withdrawal->montant_net} FCFA à {$withdrawal->phone_number}",
            'ip' => request()->ip(),
        ]);

        try {
            $withdrawal->vendeur->notify(new WithdrawalPaidNotification($withdrawal));
        } catch (\Exception $e) {
            \Log::error('Erreur notification retrait payé', ['error' => $e->getMessage()]);
        }

        session()->flash('success', 'Retrait marqué comme payé.');
    }

    public function render()
    {
        $query = Withdrawal::with('vendeur');
        if ($this->filterStatut) {
            $query->where('statut', $this->filterStatut);
        }
        $retraits = $query->orderByDesc('date_creation')->paginate(20);

        $stats = Withdrawal::selectRaw('statut, COUNT(*) as nb, COALESCE(SUM(montant_net), 0) as total')
            ->groupBy('statut')->get()->keyBy('statut');

        $this->retraitsEvolution = [];
        $this->montantEvolution = [];
        $days = collect(range(7, 1))->map(fn ($d) => now()->subDays($d)->startOfDay());
        foreach ($days as $day) {
            $next = $day->copy()->addDay();
            $this->retraitsEvolution[] = Withdrawal::where('date_creation', '<', $next)->count();
            $this->montantEvolution[] = (int) (Withdrawal::where('date_creation', '<', $next)
                ->whereIn('statut', ['paid', 'approved'])
                ->sum('montant_net') ?? 0);
        }

        return view('livewire.admin.retrait-manager', compact('retraits', 'stats'));
    }
}
