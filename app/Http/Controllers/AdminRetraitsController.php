<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Notifications\WithdrawalApprovedNotification;
use App\Notifications\WithdrawalRejectedNotification;
use App\Notifications\WithdrawalPaidNotification;
use Illuminate\Http\Request;

class AdminRetraitsController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with('vendeur');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $retraits = $query->orderByDesc('date_creation')->get();

        $stats = Withdrawal::selectRaw('statut, COUNT(*) as nb, COALESCE(SUM(montant_net), 0) as total')
            ->groupBy('statut')
            ->get()
            ->keyBy('statut');

        if ($request->isMethod('post')) {
            $action = $request->input('action');
            $withdrawal = Withdrawal::with('vendeur')->find($request->withdrawal_id);

            if ($withdrawal) {
                match ($action) {
                    'approve' => $withdrawal->update([
                        'statut' => 'approved',
                        'date_traitement' => now(),
                    ]),
                    'reject' => $withdrawal->update([
                        'statut' => 'rejected',
                        'note' => $request->note,
                        'date_traitement' => now(),
                    ]),
                    'pay' => $withdrawal->update([
                        'statut' => 'paid',
                        'date_traitement' => now(),
                    ]),
                    default => null,
                };

                if (in_array($action, ['approve', 'reject', 'pay'])) {
                    $notification = match ($action) {
                        'approve' => new WithdrawalApprovedNotification($withdrawal),
                        'reject' => new WithdrawalRejectedNotification($withdrawal),
                        'pay' => new WithdrawalPaidNotification($withdrawal),
                    };
                    $this->safeNotify($withdrawal->vendeur, $notification);
                }
            }

            return redirect()->route('admin.retraits')->with('success', 'Retrait mis à jour.');
        }

        return view('admin.retraits', compact('retraits', 'stats'));
    }

    private function safeNotify($notifiable, $notification): void
    {
        try {
            $notifiable->notify($notification);
        } catch (\Exception $e) {
            \Log::error('Erreur notification retrait', ['error' => $e->getMessage()]);
        }
    }
}
