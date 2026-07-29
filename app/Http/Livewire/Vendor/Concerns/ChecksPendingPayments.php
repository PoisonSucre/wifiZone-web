<?php

namespace App\Http\Livewire\Vendor\Concerns;

use App\Models\Transaction;
use App\Services\LigdiCashService;
use App\Services\TicketService;
use Illuminate\Support\Facades\Log;

trait ChecksPendingPayments
{
    public ?string $checkMessage = null;
    public bool $checkSuccess = false;

    public function checkTransaction(int $transactionId): void
    {
        $vendeur = auth()->user();
        $transaction = Transaction::where('id', $transactionId)
            ->where('vendeur_id', $vendeur->id)
            ->first();

        if (!$transaction || !in_array($transaction->statut, ['pending', 'notcompleted'])) {
            $this->checkMessage = 'Transaction introuvable ou déjà traitée.';
            $this->checkSuccess = false;
            return;
        }

        $confirmData = app(LigdiCashService::class)->confirmPayment($transaction->token);
        $status = $confirmData['data']['status'] ?? $confirmData['status'] ?? 'unknown';

        if ($status !== 'completed') {
            $this->checkMessage = 'Le paiement n\'est pas confirmé par LigdiCash.';
            $this->checkSuccess = false;
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($transaction, $vendeur, $confirmData) {
            $transaction->update([
                'statut' => 'completed',
                'phone_number' => $confirmData['data']['phone_number'] ?? $confirmData['phone_number'] ?? null,
                'verification_status' => 'verified',
            ]);

            $ticket = app(TicketService::class)->assignTicket(
                $transaction->vendeur_id,
                $transaction->montant,
                $transaction->token
            );

            if ($ticket) {
                $transaction->update(['ticket_id' => $ticket->id]);

                $commissionPct = $vendeur->commission_pct ?? config('platform.commission_pct', 10);
                $commission = $transaction->montant * ($commissionPct / 100);
                $transaction->update(['commission' => $commission]);
            } else {
                Log::warning('checkTransaction: no available ticket', [
                    'vendeur_id' => $vendeur->id,
                    'montant' => $transaction->montant,
                ]);
            }
        });

        if (method_exists($this, 'refreshStuck')) {
            $this->refreshStuck();
        }
        $this->checkMessage = 'Paiement confirmé et ticket attribué avec succès.';
        $this->checkSuccess = true;
    }
}
