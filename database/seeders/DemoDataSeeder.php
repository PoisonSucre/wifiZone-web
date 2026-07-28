<?php

namespace Database\Seeders;

use App\Models\Hotspot;
use App\Models\Vendeur;
use App\Models\Forfait;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\ImportBatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    private int $targetRevenus = 55500;
    private int $currentSum = 0;

    public function run(): void
    {
        $vendeur = Vendeur::where('email', 'ranihamedt@gmail.com')->first();

        if (!$vendeur) {
            $this->command?->error('Vendeur ranihamedt@gmail.com non trouvé.');
            return;
        }

        $hotspot = Hotspot::where('vendeur_id', $vendeur->id)->first();

        $this->cleanup($vendeur);
        $this->createForfaits($vendeur, $hotspot);
        $this->createTickets($vendeur, $hotspot);
        $this->createWithdrawals($vendeur, $hotspot);
        $this->createImportBatches($vendeur, $hotspot);

        $this->command?->info("Données de démo créées pour {$vendeur->email}");
    }

    private function cleanup(Vendeur $vendeur): void
    {
        DB::table('transactions')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('ticket')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('withdrawals')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('import_batches')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('vendor_forfaits')->where('vendeur_id', $vendeur->id)->delete();

        $this->command?->info('Données existantes supprimées.');
    }

    private function createForfaits(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        $forfaits = [
            ['label' => '1 Heure',  'montant' => 150,  'duree_minutes' => 60,    'ordre' => 1],
            ['label' => '5 Heures', 'montant' => 250,  'duree_minutes' => 300,   'ordre' => 2],
            ['label' => '24 Heures','montant' => 350,  'duree_minutes' => 1440,  'ordre' => 3],
            ['label' => '3 Jours',  'montant' => 600,  'duree_minutes' => 4320,  'ordre' => 4],
            ['label' => '7 Jours',  'montant' => 1000, 'duree_minutes' => 10080, 'ordre' => 5],
        ];

        foreach ($forfaits as $f) {
            Forfait::create(array_merge($f, [
                'vendeur_id' => $vendeur->id,
                'actif' => true,
                'hotspot_id' => $hotspot?->id,
            ]));
        }
    }

    private function createTickets(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        $sources = ['api', 'import', 'manual'];
        $phoneNumbers = ['+22601020304', '+22605060708', '+22609101112', '+22613141516'];

        for ($i = 0; $i < 12; $i++) {
            $fi = $i % 5;
            $forfaits = ['1 Heure', '5 Heures', '24 Heures', '3 Jours', '7 Jours'];
            $montants = [150, 250, 350, 600, 1000];

            Ticket::create([
                'vendeur_id'    => $vendeur->id,
                'hotspot_id'    => $hotspot?->id,
                'user'          => 'USR-' . strtoupper(Str::random(6)),
                'password'      => Str::random(8),
                'forfait'       => $forfaits[$fi],
                'montant'       => $montants[$fi],
                'token'         => Str::random(32),
                'status'        => 'disponible',
                'source'        => $sources[$i % 3],
                'date_creation' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->currentSum = 0;

        $soldPlan = [
            ['forfait' => '7 Jours',  'montant' => 1000, 'count' => 35],
            ['forfait' => '3 Jours',  'montant' => 600,  'count' => 10],
            ['forfait' => '24 Heures','montant' => 350,  'count' => 10],
            ['forfait' => '5 Heures', 'montant' => 250,  'count' => 10],
            ['forfait' => '1 Heure',  'montant' => 150,  'count' => 5],
        ];

        foreach ($soldPlan as $plan) {
            for ($i = 0; $i < $plan['count']; $i++) {
                if ($this->currentSum >= $this->targetRevenus) break;

                $ticket = Ticket::create([
                    'vendeur_id'    => $vendeur->id,
                    'hotspot_id'    => $hotspot?->id,
                    'user'          => 'USR-' . strtoupper(Str::random(6)),
                    'password'      => Str::random(8),
                    'forfait'       => $plan['forfait'],
                    'montant'       => $plan['montant'],
                    'token'         => Str::random(32),
                    'status'        => 'vendu',
                    'source'        => $sources[array_rand($sources)],
                    'date_creation' => now()->subDays(rand(1, 28)),
                ]);

                $commission = round($plan['montant'] * ($vendeur->commission_pct / 100), 2);

                Transaction::create([
                    'vendeur_id'          => $vendeur->id,
                    'hotspot_id'          => $hotspot?->id,
                    'ticket_id'           => $ticket->id,
                    'token'               => $ticket->token,
                    'transaction_id'      => 'TXN-' . strtoupper(Str::random(8)),
                    'montant'             => $plan['montant'],
                    'commission'          => $commission,
                    'statut'              => 'completed',
                    'phone_number'        => $phoneNumbers[array_rand($phoneNumbers)],
                    'verification_status' => 'verified',
                    'date_creation'       => now()->subDays(rand(1, 28))->subHours(rand(0, 23)),
                ]);

                $this->currentSum += $plan['montant'];
            }
            if ($this->currentSum >= $this->targetRevenus) break;
        }
    }

    private function createWithdrawals(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        $dejaRetirer = 35500;
        $revenus = $this->currentSum;
        $targetSolde = 20000;
        $montantsRetires = $revenus - $targetSolde;

        $withdrawals = [
            [
                'montant_brut' => 15000,
                'statut'       => 'paid',
                'phone_number' => '+22601020304',
                'date_traitement' => now()->subDays(15),
            ],
            [
                'montant_brut' => 8500,
                'statut'       => 'paid',
                'phone_number' => '+22605060708',
                'date_traitement' => now()->subDays(8),
            ],
            [
                'montant_brut' => 12000,
                'statut'       => 'approved',
                'phone_number' => '+22609101112',
                'note'         => 'Retrait en cours de traitement',
            ],
            [
                'montant_brut' => 5000,
                'statut'       => 'pending',
                'phone_number' => '+22613141516',
            ],
        ];

        $paidApprovedTotal = 0;
        foreach ($withdrawals as $w) {
            if (in_array($w['statut'], ['paid', 'approved'])) {
                $paidApprovedTotal += $w['montant_brut'];
            }
        }

        $scale = $paidApprovedTotal > 0 ? $montantsRetires / $paidApprovedTotal : 1;

        foreach ($withdrawals as $w) {
            $scaledMontant = $w['statut'] === 'pending'
                ? $w['montant_brut']
                : (int) round($w['montant_brut'] * $scale);

            $commissionPct = $vendeur->commission_pct;
            $montantCommission = round($scaledMontant * ($commissionPct / 100), 2);
            $montantNet = $scaledMontant - $montantCommission;

            Withdrawal::create(array_merge($w, [
                'vendeur_id'          => $vendeur->id,
                'hotspot_id'          => $hotspot?->id,
                'montant_brut'        => $scaledMontant,
                'commission_pct'      => $commissionPct,
                'montant_commission'  => $montantCommission,
                'montant_net'         => $montantNet,
                'date_creation'       => now()->subDays(rand(5, 30)),
            ]));
        }
    }

    private function createImportBatches(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        ImportBatch::create([
            'vendeur_id'     => $vendeur->id,
            'hotspot_id'     => $hotspot?->id,
            'filename'       => 'tickets_batch_001.csv',
            'format_file'    => 'csv',
            'total_tickets'  => 20,
            'statut'         => 'success',
            'imported_at'    => now()->subDays(10),
        ]);

        ImportBatch::create([
            'vendeur_id'     => $vendeur->id,
            'hotspot_id'     => $hotspot?->id,
            'filename'       => 'tickets_batch_002.csv',
            'format_file'    => 'csv',
            'total_tickets'  => 15,
            'statut'         => 'partial',
            'imported_at'    => now()->subDays(3),
        ]);
    }
}
