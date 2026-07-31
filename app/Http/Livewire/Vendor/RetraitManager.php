<?php

namespace App\Http\Livewire\Vendor;

use App\Mail\WithdrawalRequestedMail;
use App\Models\Admin;
use App\Models\Setting;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RetraitManager extends Component
{
    public int $montant = 0;
    public string $phoneNumber = '';
    public string $operator = '';

    public function mount(): void
    {
        $this->phoneNumber = auth()->user()->telephone ?? '';
    }

    public function demanderRetrait(): void
    {
        $this->validate([
            'montant' => 'required|integer|min:1',
            'phoneNumber' => 'required|string|max:20',
            'operator' => 'required|in:orange,moov',
        ]);

        $error = null;

        try {
            DB::transaction(function () use (&$error) {
                $vendeur = auth()->user();

                $vendeur->lockForUpdate();

                $totalRevenus = $vendeur->transactions()->completed()->sum('montant') ?? 0;
                $dejaRetire = $vendeur->withdrawals()->whereIn('statut', ['pending', 'approved', 'paid'])->sum('montant_brut') ?? 0;
                $soldeDisponible = max(0, $totalRevenus - $dejaRetire);
                $commissionPct = $vendeur->commission_pct ?? config('platform.commission_pct', 10);

                if ($this->montant > $soldeDisponible) {
                    $error = 'Solde insuffisant.';
                    return;
                }

                $comm = $this->montant * ($commissionPct / 100);
                $net = $this->montant - $comm;

                Withdrawal::create([
                    'vendeur_id' => $vendeur->id,
                    'montant_brut' => $this->montant,
                    'commission_pct' => $commissionPct,
                    'montant_commission' => $comm,
                    'montant_net' => $net,
                    'phone_number' => $this->phoneNumber,
                    'operator' => $this->operator,
                ]);
            });

            if ($error) {
                session()->now('error', $error);
                $this->dispatch('retrait-error');
                return;
            }

            try {
                $vendeur = auth()->user();
                $withdrawal = $vendeur->withdrawals()->latest()->first();
                if ($withdrawal) {
                    $admins = Admin::pluck('email');
                    if ($admins->isNotEmpty()) {
                        Mail::to($admins->first())
                            ->bcc($admins->slice(1)->toArray())
                            ->send(new WithdrawalRequestedMail($withdrawal));
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Erreur notification retrait demandé', ['error' => $e->getMessage()]);
            }

            $this->montant = 0;
            $this->phoneNumber = '';
            $this->operator = '';
            session()->now('success', 'Demande de retrait soumise.');
            $this->dispatch('retrait-submitted');

        } catch (\Exception $e) {
            \Log::error('Erreur demande retrait', ['error' => $e->getMessage()]);
            $this->dispatch('retrait-error');
        }
    }

    public function render()
    {
        $vendeur = auth()->user();
        $totalRevenus = $vendeur->transactions()->completed()->sum('montant') ?? 0;
        $dejaRetire = $vendeur->withdrawals()->whereIn('statut', ['pending', 'approved', 'paid'])->sum('montant_brut') ?? 0;
        $commissionPct = $vendeur->commission_pct ?? config('platform.commission_pct', 10);
        $soldeDisponible = max(0, $totalRevenus - $dejaRetire);
        $soldeNet = $soldeDisponible * (1 - $commissionPct / 100);
        $retraits = $vendeur->withdrawals()->orderByDesc('date_creation')->paginate(20);

        return view('livewire.vendor.retrait-manager', compact(
            'vendeur', 'totalRevenus', 'dejaRetire', 'commissionPct',
            'soldeDisponible', 'soldeNet', 'retraits'
        ));
    }
}
