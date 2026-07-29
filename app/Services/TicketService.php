<?php

namespace App\Services;

use App\Models\Forfait;
use App\Models\ImportBatch;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public function assignTicket(int $vendeurId, int $montant, string $token): ?Ticket
    {
        return DB::transaction(function () use ($vendeurId, $montant, $token) {
            $ticket = Ticket::where('vendeur_id', $vendeurId)
                ->available()
                ->where('montant', $montant)
                ->lockForUpdate()
                ->first();

            if (!$ticket) {
                return null;
            }

            $ticket->update([
                'status' => 'vendu',
                'token' => $token,
                'date_creation' => now(),
            ]);

            return $ticket;
        });
    }

    public function importFromCsv(int $vendeurId, UploadedFile $file, string $mode = 'with_password', ?int $hotspotId = null): array
    {
        $content = file_get_contents($file->getRealPath());
        $lines = array_filter(explode("\n", $content));

        $existingUsers = Ticket::where('vendeur_id', $vendeurId)
            ->pluck('user')
            ->toArray();

        $vendorForfaits = Forfait::where('vendeur_id', $vendeurId)->get();
        $created = 0;
        $skipped = 0;
        $missingPassword = 0;
        $maxPerImport = 500;

        foreach ($lines as $i => $line) {
            if ($i === 0) continue;
            if ($created >= $maxPerImport) break;

            $parts = str_getcsv($line, ';');

            if ($mode === 'without_password') {
                if (count($parts) < 2) continue;

                $user = trim($parts[0] ?? '');
                $forfaitLabel = trim($parts[1] ?? 'Standard');
                $montant = (int) ($parts[2] ?? 150);

                $pass = bin2hex(random_bytes(6));
            } else {
                if (count($parts) < 2) continue;

                $user = trim($parts[0] ?? '');
                $pass = trim($parts[1] ?? '');
                $forfaitLabel = trim($parts[2] ?? 'Standard');
                $montant = (int) ($parts[3] ?? 150);

                if (empty($user)) continue;

                if (empty($pass)) {
                    $missingPassword++;
                    continue;
                }
            }

            if (empty($user)) continue;

            if (in_array($user, $existingUsers)) {
                $skipped++;
                continue;
            }

            $forfait = $vendorForfaits->firstWhere('label', $forfaitLabel);
            if ($forfait) {
                $montant = $forfait->montant;
                $forfaitLabel = $forfait->label;
            }

            Ticket::create([
                'vendeur_id' => $vendeurId,
                'hotspot_id' => $hotspotId,
                'user' => $user,
                'password' => $pass,
                'forfait' => $forfaitLabel,
                'montant' => $montant,
                'source' => 'import',
            ]);

            $existingUsers[] = $user;
            $created++;
        }

        ImportBatch::create([
            'vendeur_id' => $vendeurId,
            'filename' => $file->getClientOriginalName(),
            'format_file' => 'csv',
            'total_tickets' => $created,
            'statut' => $created > 0 ? 'success' : 'error',
        ]);

        $message = "{$created} tickets importés, {$skipped} doublons ignorés";
        if ($missingPassword > 0) {
            $message .= ", {$missingPassword} ignorés (mot de passe manquant)";
        }
        $message .= ".";

        return [
            'created' => $created,
            'skipped' => $skipped,
            'missing_password' => $missingPassword,
            'message' => $message,
        ];
    }

    public function generateBatch(int $vendeurId, array $params): int
    {
        $vendeur = \App\Models\Vendeur::find($vendeurId);
        $forfait = Forfait::find($params['forfait_id']);

        if (!$forfait) return 0;

        $count = min(500, $params['count']);
        $created = 0;

        for ($i = 0; $i < $count; $i++) {
            $num = $params['start_number'] + $i;
            $user = $params['prefix'] . str_pad($num, 4, '0', STR_PAD_LEFT);
            $pass = bin2hex(random_bytes(intdiv($params['pass_length'], 2) + 1));
            $pass = substr($pass, 0, $params['pass_length']);

            Ticket::create([
                'vendeur_id' => $vendeurId,
                'user' => $user,
                'password' => $pass,
                'forfait' => $forfait->label,
                'montant' => $forfait->montant,
                'source' => 'manual',
            ]);

            $created++;
        }

        return $created;
    }

    public function getAvailableCount(int $vendeurId): int
    {
        return Ticket::where('vendeur_id', $vendeurId)->available()->count();
    }

    public function getSoldCount(int $vendeurId): int
    {
        return Ticket::where('vendeur_id', $vendeurId)->sold()->count();
    }
}
