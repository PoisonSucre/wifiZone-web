<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class StatsService
{
    public function periodData(int $days): array
    {
        return Cache::remember("stats.period.{$days}", 300, function () use ($days) {
            $startDate = now()->subDays($days)->startOfDay();

            $rows = Transaction::where('statut', 'completed')
                ->where('date_creation', '>=', $startDate)
                ->selectRaw('DATE(date_creation) as date')
                ->selectRaw('COALESCE(SUM(montant), 0) as montant')
                ->selectRaw('COALESCE(SUM(commission), 0) as commission')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->keyBy('date');

            $labels = [];
            $revenus = [];
            $commissions = [];

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $labels[] = now()->subDays($i)->format('d/m');
                $row = $rows[$date] ?? null;
                $revenus[] = (int) ($row->montant ?? 0);
                $commissions[] = (int) ($row->commission ?? 0);
            }

            return compact('labels', 'revenus', 'commissions');
        });
    }

    public function totalRevenus(): float
    {
        return Cache::remember('stats.total_revenus', 300, function () {
            return Transaction::where('statut', 'completed')->sum('montant') ?? 0;
        });
    }

    public function totalCommissions(): float
    {
        return Cache::remember('stats.total_commissions', 300, function () {
            return Transaction::where('statut', 'completed')->sum('commission') ?? 0;
        });
    }

    public function evolution(int $currentDays = 7, int $previousDays = 7): array
    {
        return Cache::remember("stats.evolution.{$currentDays}.{$previousDays}", 300, function () use ($currentDays, $previousDays) {
            $currentStart = now()->subDays($currentDays)->startOfDay();
            $previousStart = now()->subDays($currentDays + $previousDays)->startOfDay();

            $current = Transaction::where('statut', 'completed')
                ->where('date_creation', '>=', $currentStart)
                ->selectRaw('COALESCE(SUM(montant), 0) as montant, COALESCE(SUM(commission), 0) as commission')
                ->first();

            $previous = Transaction::where('statut', 'completed')
                ->where('date_creation', '>=', $previousStart)
                ->where('date_creation', '<', $currentStart)
                ->selectRaw('COALESCE(SUM(montant), 0) as montant, COALESCE(SUM(commission), 0) as commission')
                ->first();

            $curRev = (float) ($current->montant ?? 0);
            $curCom = (float) ($current->commission ?? 0);
            $prevRev = (float) ($previous->montant ?? 0);
            $prevCom = (float) ($previous->commission ?? 0);

            return [
                'current_revenus' => $curRev,
                'current_commissions' => $curCom,
                'previous_revenus' => $prevRev,
                'previous_commissions' => $prevCom,
                'revenus_pct' => $prevRev > 0 ? round((($curRev - $prevRev) / $prevRev) * 100, 1) : 0,
                'commissions_pct' => $prevCom > 0 ? round((($curCom - $prevCom) / $prevCom) * 100, 1) : 0,
            ];
        });
    }

    public function sparkline(array $data, string $color, int $h = 28, string $key = 'sp'): string
    {
        $data = array_values(array_filter($data, fn ($v) => is_numeric($v)));
        $id = 'sp_' . preg_replace('/[^a-z0-9]/i', '', $key);

        if (count($data) < 2) {
            $midY = $h / 2;
            return '<svg class="w-full block" viewBox="0 0 100 ' . $h . '" preserveAspectRatio="none" style="height:' . $h . 'px">'
                . '<defs><linearGradient id="' . $id . '" x1="0" x2="0" y1="0" y2="1">'
                . '<stop offset="0%" stop-color="' . $color . '" stop-opacity="0.3"/>'
                . '<stop offset="100%" stop-color="' . $color . '" stop-opacity="0"/>'
                . '</linearGradient></defs>'
                . '<polygon points="0,' . $midY . ' 100,' . $midY . ' 100,' . $h . ' 0,' . $h . '" fill="url(#' . $id . ')"/>'
                . '<polyline points="0,' . $midY . ' 100,' . $midY . '" fill="none" stroke="' . $color . '" stroke-width="1.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>'
                . '</svg>';
        }

        $max = max($data);
        $min = min($data);
        $range = max($max - $min, 0.0001);
        $n = count($data);
        $pts = [];

        foreach ($data as $i => $v) {
            $x = ($i / ($n - 1)) * 100;
            $y = $h - (($v - $min) / $range) * ($h - 6) - 3;
            $pts[] = round($x, 2) . ',' . round($y, 2);
        }

        $line = implode(' ', $pts);
        $area = $line . " 100,{$h} 0,{$h}";

        return '<svg class="w-full block" viewBox="0 0 100 ' . $h . '" preserveAspectRatio="none" style="height:' . $h . 'px">'
            . '<defs><linearGradient id="' . $id . '" x1="0" x2="0" y1="0" y2="1">'
            . '<stop offset="0%" stop-color="' . $color . '" stop-opacity="0.3"/>'
            . '<stop offset="100%" stop-color="' . $color . '" stop-opacity="0"/>'
            . '</linearGradient></defs>'
            . '<polygon points="' . $area . '" fill="url(#' . $id . ')"/>'
            . '<polyline points="' . $line . '" fill="none" stroke="' . $color . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>'
            . '</svg>';
    }
}
