<?php

namespace Database\Seeders;

use App\Models\Hotspot;
use App\Models\Vendeur;
use App\Models\Forfait;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemoVendeursSeeder extends Seeder
{
    private array $forfaitsConfig = [
        ['label' => '1 Heure',   'montant' => 150,  'duree_minutes' => 60,    'ordre' => 1],
        ['label' => '5 Heures',  'montant' => 250,  'duree_minutes' => 300,   'ordre' => 2],
        ['label' => '24 Heures', 'montant' => 350,  'duree_minutes' => 1440,  'ordre' => 3],
        ['label' => '3 Jours',   'montant' => 600,  'duree_minutes' => 4320,  'ordre' => 4],
        ['label' => '7 Jours',   'montant' => 1000, 'duree_minutes' => 10080, 'ordre' => 5],
    ];

    private array $phoneNumbers = [
        '+22607111111', '+22607222222', '+22607333333', '+22607444444',
        '+22607555555', '+22607666666', '+22607777777', '+22607888888',
    ];

    public function run(): void
    {
        $vendors = [
            'amadou' => Vendeur::where('email', 'amadou@test.com')->first(),
            'fatima' => Vendeur::where('email', 'fatima@test.com')->first(),
            'ibrahim' => Vendeur::where('email', 'ibrahim@test.com')->first(),
        ];

        foreach ($vendors as $key => $vendeur) {
            if (!$vendeur) {
                $this->command?->warn("Vendeur {$key} non trouvé, skip.");
                continue;
            }

            $hotspot = Hotspot::where('vendeur_id', $vendeur->id)->first();

            $this->cleanup($vendeur);
            $this->createForfaits($vendeur, $hotspot);

            match ($key) {
                'amadou' => $this->seedAmadou($vendeur, $hotspot),
                'fatima' => $this->seedFatima($vendeur, $hotspot),
                'ibrahim' => $this->seedIbrahim($vendeur, $hotspot),
            };

            $this->command?->info("Données créées pour {$vendeur->prenom} {$vendeur->nom} ({$vendeur->commission_pct}%)");
        }
    }

    private function cleanup(Vendeur $vendeur): void
    {
        DB::table('transactions')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('ticket')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('withdrawals')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('import_batches')->where('vendeur_id', $vendeur->id)->delete();
        DB::table('vendor_forfaits')->where('vendeur_id', $vendeur->id)->delete();
    }

    private function createForfaits(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        foreach ($this->forfaitsConfig as $f) {
            Forfait::create(array_merge($f, [
                'vendeur_id' => $vendeur->id,
                'actif' => true,
                'hotspot_id' => $hotspot?->id,
            ]));
        }
    }

    private function seedAmadou(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        $soldPlan = [
            ['forfait' => '7 Jours',   'montant' => 1000, 'daysAgo' => [18, 25]],
            ['forfait' => '3 Jours',   'montant' => 600,  'daysAgo' => [14, 20]],
            ['forfait' => '24 Heures', 'montant' => 350,  'daysAgo' => [8, 12, 18]],
            ['forfait' => '5 Heures',  'montant' => 250,  'daysAgo' => [3, 5, 8, 12]],
            ['forfait' => '1 Heure',   'montant' => 150,  'daysAgo' => [1, 1, 2, 3, 4, 5, 6, 7]],
        ];

        foreach ($soldPlan as $plan) {
            foreach ($plan['daysAgo'] as $daysAgo) {
                $this->sellTicket($vendeur, $hotspot, $plan['forfait'], $plan['montant'], $daysAgo);
            }
        }

        for ($i = 0; $i < 8; $i++) {
            $fi = $i % 5;
            $this->createAvailableTicket($vendeur, $hotspot, $fi);
        }

        $this->createWithdrawals($vendeur, $hotspot, [
            ['montant_brut' => 2000, 'statut' => 'paid', 'daysAgo' => 15],
            ['montant_brut' => 1500, 'statut' => 'pending', 'daysAgo' => 2],
        ]);
    }

    private function seedFatima(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        $soldPlan = [
            ['forfait' => '7 Jours',   'montant' => 1000, 'daysAgo' => [4, 12, 22]],
            ['forfait' => '3 Jours',   'montant' => 600,  'daysAgo' => [2, 8, 15, 25]],
            ['forfait' => '24 Heures', 'montant' => 350,  'daysAgo' => [3, 7, 13, 19, 27]],
            ['forfait' => '5 Heures',  'montant' => 250,  'daysAgo' => [1, 5, 9, 16, 21]],
            ['forfait' => '1 Heure',   'montant' => 150,  'daysAgo' => [2, 6, 10, 14, 20]],
        ];

        foreach ($soldPlan as $plan) {
            foreach ($plan['daysAgo'] as $daysAgo) {
                $this->sellTicket($vendeur, $hotspot, $plan['forfait'], $plan['montant'], $daysAgo);
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $fi = $i % 5;
            $this->createAvailableTicket($vendeur, $hotspot, $fi);
        }

        $this->createWithdrawals($vendeur, $hotspot, [
            ['montant_brut' => 5000, 'statut' => 'paid', 'daysAgo' => 10],
            ['montant_brut' => 3000, 'statut' => 'paid', 'daysAgo' => 3],
            ['montant_brut' => 2000, 'statut' => 'approved', 'daysAgo' => 0],
        ]);
    }

    private function seedIbrahim(Vendeur $vendeur, ?Hotspot $hotspot): void
    {
        $soldPlan = [
            ['forfait' => '7 Jours',   'montant' => 1000, 'daysAgo' => [10, 15, 22, 27]],
            ['forfait' => '3 Jours',   'montant' => 600,  'daysAgo' => [8, 14, 20, 25]],
            ['forfait' => '24 Heures', 'montant' => 350,  'daysAgo' => [12, 18, 24]],
            ['forfait' => '5 Heures',  'montant' => 250,  'daysAgo' => [15, 21]],
            ['forfait' => '1 Heure',   'montant' => 150,  'daysAgo' => [18, 23, 26]],
        ];

        foreach ($soldPlan as $plan) {
            foreach ($plan['daysAgo'] as $daysAgo) {
                $this->sellTicket($vendeur, $hotspot, $plan['forfait'], $plan['montant'], $daysAgo);
            }
        }

        for ($i = 0; $i < 6; $i++) {
            $fi = $i % 5;
            $this->createAvailableTicket($vendeur, $hotspot, $fi);
        }

        $this->createWithdrawals($vendeur, $hotspot, [
            ['montant_brut' => 4000, 'statut' => 'paid', 'daysAgo' => 20],
            ['montant_brut' => 2500, 'statut' => 'paid', 'daysAgo' => 8],
        ]);
    }

    private function sellTicket(Vendeur $vendeur, ?Hotspot $hotspot, string $forfait, int $montant, int $daysAgo): void
    {
        $ticket = Ticket::create([
            'vendeur_id'    => $vendeur->id,
            'hotspot_id'    => $hotspot?->id,
            'user'          => 'USR-' . strtoupper(Str::random(6)),
            'password'      => Str::random(8),
            'forfait'       => $forfait,
            'montant'       => $montant,
            'token'         => Str::random(32),
            'status'        => 'vendu',
            'source'        => ['api', 'import', 'manual'][array_rand(['api', 'import', 'manual'])],
            'date_creation' => now()->subDays($daysAgo)->subHours(rand(0, 12)),
        ]);

        $commission = round($montant * ($vendeur->commission_pct / 100), 2);

        Transaction::create([
            'vendeur_id'          => $vendeur->id,
            'hotspot_id'          => $hotspot?->id,
            'ticket_id'           => $ticket->id,
            'token'               => $ticket->token,
            'transaction_id'      => 'TXN-' . strtoupper(Str::random(8)),
            'montant'             => $montant,
            'commission'          => $commission,
            'statut'              => 'completed',
            'phone_number'        => $this->phoneNumbers[array_rand($this->phoneNumbers)],
            'verification_status' => 'verified',
            'date_creation'       => now()->subDays($daysAgo)->subHours(rand(0, 23)),
        ]);
    }

    private function createAvailableTicket(Vendeur $vendeur, ?Hotspot $hotspot, int $forfaitIndex): void
    {
        Ticket::create([
            'vendeur_id'    => $vendeur->id,
            'hotspot_id'    => $hotspot?->id,
            'user'          => 'USR-' . strtoupper(Str::random(6)),
            'password'      => Str::random(8),
            'forfait'       => $this->forfaitsConfig[$forfaitIndex]['label'],
            'montant'       => $this->forfaitsConfig[$forfaitIndex]['montant'],
            'token'         => Str::random(32),
            'status'        => 'disponible',
            'source'        => 'import',
            'date_creation' => now()->subDays(rand(1, 5)),
        ]);
    }

    private function createWithdrawals(Vendeur $vendeur, ?Hotspot $hotspot, array $withdrawals): void
    {
        foreach ($withdrawals as $w) {
            $commission = round($w['montant_brut'] * ($vendeur->commission_pct / 100), 2);
            $net = $w['montant_brut'] - $commission;

            Withdrawal::create([
                'vendeur_id'         => $vendeur->id,
                'hotspot_id'         => $hotspot?->id,
                'montant_brut'       => $w['montant_brut'],
                'commission_pct'     => $vendeur->commission_pct,
                'montant_commission' => $commission,
                'montant_net'        => $net,
                'statut'             => $w['statut'],
                'phone_number'       => $this->phoneNumbers[array_rand($this->phoneNumbers)],
                'date_creation'      => now()->subDays($w['daysAgo']),
                'date_traitement'    => in_array($w['statut'], ['paid', 'approved'])
                    ? now()->subDays(max(0, $w['daysAgo'] - 2))
                    : null,
            ]);
        }
    }
}
