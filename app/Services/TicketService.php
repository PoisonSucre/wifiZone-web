<?php

namespace App\Services;

use App\Models\Forfait;
use App\Models\ImportBatch;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function importFromCsv(int $vendeurId, UploadedFile $file, string $mode = 'with_password', int $hotspotId = 0): array
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $isExcel = in_array($ext, ['xlsx', 'xls']);

        $rows = $isExcel ? $this->readExcelRows($file) : $this->readCsvRows($file);

        $existingUsers = Ticket::where('vendeur_id', $vendeurId)
            ->pluck('user')
            ->toArray();

        $vendorForfaits = Forfait::where('vendeur_id', $vendeurId)->get();
        $created = 0;
        $skipped = 0;
        $missingPassword = 0;
        $maxPerImport = 500;

        return DB::transaction(function () use ($vendeurId, $hotspotId, $rows, $existingUsers, $vendorForfaits, $mode, $maxPerImport, $file, $ext, &$created, &$skipped, &$missingPassword) {
            $existingSet = array_flip($existingUsers);

            foreach ($rows as $i => $parts) {
                if ($created >= $maxPerImport) break;

                if ($mode === 'without_password') {
                    if (count($parts) < 2) continue;

                    $user = trim($parts[0] ?? '');
                    $forfaitLabel = trim($parts[1] ?? 'Standard');
                    $montant = (int) ($parts[2] ?? 150);

                    $pass = bin2hex(random_bytes(12));
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

                if (isset($existingSet[$user])) {
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
                    'hotspot_id' => $hotspotId ?: null,
                    'user' => $user,
                    'password' => $pass,
                    'forfait' => $forfaitLabel,
                    'montant' => $montant,
                    'source' => 'import',
                ]);

                $existingSet[$user] = true;
                $created++;
            }

            ImportBatch::create([
                'vendeur_id' => $vendeurId,
                'filename' => $file->getClientOriginalName(),
                'format_file' => $isExcel ? 'excel' : 'csv',
                'total_tickets' => $created,
                'statut' => $created > 0 ? 'success' : 'error',
            ]);

            $message = "{$created} tickets importés, {$skipped} doublons ignorés";
            if ($missingPassword > 0) {
                $message .= ", {$missingPassword} ignorés (mot de passe manquant)";
            }
            $message .= ".";

            return compact('created', 'skipped', 'missing_password', 'message');
        });
    }

    /**
     * Import tickets from a Mikhmon CSV/Excel export.
     *
     * Mikhmon CSV format:
     *   Username,Password,Profile,Time Limit,Data Limit,Comment
     *
     * The montant (price) is NOT in the Mikhmon file — it comes from the
     * selected forfait configured by the vendor in the platform.
     */
    public function importFromMikhmon(int $vendeurId, UploadedFile $file, int $forfaitId, int $hotspotId): array
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $isExcel = in_array($ext, ['xlsx', 'xls']);

        $rows = $isExcel ? $this->readExcelRows($file) : $this->readCsvRows($file);

        $forfait = Forfait::where('id', $forfaitId)->where('vendeur_id', $vendeurId)->first();
        if (!$forfait) {
            return [
                'created' => 0,
                'skipped' => 0,
                'invalid' => 0,
                'message' => 'Forfait introuvable. Configurez vos forfaits avant d\'importer.',
            ];
        }

        $existingUsers = Ticket::where('vendeur_id', $vendeurId)->pluck('user')->toArray();
        $created = 0;
        $skipped = 0;
        $invalid = 0;
        $maxPerImport = 500;

        return DB::transaction(function () use ($vendeurId, $hotspotId, $rows, $existingUsers, $forfait, $maxPerImport, $file, $ext, &$created, &$skipped, &$invalid) {
            $existingSet = array_flip($existingUsers);

            foreach ($rows as $parts) {
                if ($created >= $maxPerImport) break;

                // Mikhmon format: Username,Password,Profile,Time Limit,Data Limit,Comment
                // Col 0 = Username, Col 1 = Password, Col 2 = Profile (ignored, we use selected forfait)
                $user = trim($parts[0] ?? '');
                $pass = trim($parts[1] ?? '');

                if (empty($user)) {
                    $invalid++;
                    continue;
                }

                // In VC mode, Mikhmon sets password = username. If password empty, use username.
                if (empty($pass)) {
                    $pass = $user;
                }

                if (isset($existingSet[$user])) {
                    $skipped++;
                    continue;
                }

                Ticket::create([
                    'vendeur_id' => $vendeurId,
                    'hotspot_id' => $hotspotId ?: null,
                    'user' => $user,
                    'password' => $pass,
                    'forfait' => $forfait->label,
                    'montant' => $forfait->montant,
                    'source' => 'import',
                ]);

                $existingSet[$user] = true;
                $created++;
            }

            ImportBatch::create([
                'vendeur_id' => $vendeurId,
                'filename' => $file->getClientOriginalName(),
                'format_file' => $isExcel ? 'excel' : 'csv',
                'total_tickets' => $created,
                'statut' => $created > 0 ? 'success' : 'error',
            ]);

            $message = "{$created} tickets importés (forfait : {$forfait->label} - {$forfait->montant} FCFA)";
            if ($skipped > 0) {
                $message .= ", {$skipped} doublons ignorés";
            }
            if ($invalid > 0) {
                $message .= ", {$invalid} lignes invalides";
            }
            $message .= ".";

            return compact('created', 'skipped', 'invalid', 'message');
        });
    }

    private function readCsvRows(UploadedFile $file): array
    {
        $content = file_get_contents($file->getRealPath());
        $lines = array_filter(explode("\n", $content), fn($l) => trim($l) !== '');

        $firstLine = reset($lines);
        $delimiter = substr_count($firstLine, ';') >= substr_count($firstLine, ',') ? ';' : ',';

        // Détecte si la première ligne est un en-tête (contient "username", "user", "name", etc.)
        $firstParts = str_getcsv($firstLine, $delimiter);
        $firstColLower = strtolower(trim($firstParts[0] ?? ''));
        $headerKeywords = ['username', 'user', 'name', 'login', 'loginid', 'no'];
        $hasHeader = in_array($firstColLower, $headerKeywords);

        $rows = [];
        $i = 0;
        foreach ($lines as $line) {
            if ($i === 0 && $hasHeader) {
                $i++;
                continue;
            }
            $rows[] = str_getcsv($line, $delimiter);
            $i++;
        }

        return $rows;
    }

    private function readExcelRows(UploadedFile $file): array
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        if (empty($data)) return [];

        // Détecte si la première ligne est un en-tête
        $firstColLower = strtolower(trim($data[0][0] ?? ''));
        $headerKeywords = ['username', 'user', 'name', 'login', 'loginid', 'no'];
        $hasHeader = in_array($firstColLower, $headerKeywords);

        return $hasHeader ? array_slice($data, 1) : $data;
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
