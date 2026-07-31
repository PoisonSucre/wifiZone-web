<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminLog;
use Livewire\Component;
use Livewire\WithPagination;

class JournalManager extends Component
{
    use WithPagination;

    public string $filterAction = '';

    public string $period = '';

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    protected $queryString = [
        'filterAction' => ['except' => ''],
        'period' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function updatedFilterAction()
    {
        $this->resetPage();
    }

    public function updatedPeriod()
    {
        if ($this->period !== '') {
            $this->dateFrom = null;
            $this->dateTo = null;
        }
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        if ($this->dateFrom) {
            $this->period = '';
        }
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        if ($this->dateTo) {
            $this->period = '';
        }
        $this->resetPage();
    }

    public function clearDates()
    {
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->resetPage();
    }

    public function render()
    {
        $today = now()->startOfDay();

        $query = AdminLog::with('admin')->orderByDesc('created_at');

        if ($this->filterAction) {
            $query->where('action', $this->filterAction);
        }

        if ($this->dateFrom && $this->dateTo && $this->dateTo < $this->dateFrom) {
            [$this->dateFrom, $this->dateTo] = [$this->dateTo, $this->dateFrom];
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        if (!$this->dateFrom && !$this->dateTo) {
            switch ($this->period) {
                case 'today':
                    $query->whereDate('created_at', $today);
                    break;
                case '7':
                    $query->where('created_at', '>=', $today->copy()->subDays(6));
                    break;
                case '30':
                    $query->where('created_at', '>=', $today->copy()->subDays(29));
                    break;
                case 'month':
                    $query->whereDate('created_at', '>=', $today->copy()->startOfMonth());
                    break;
            }
        }

        $logs = $query->paginate(25);

        $actions = (clone $query)
            ->toBase()
            ->reorder()
            ->selectRaw('action, COUNT(*) as nb')
            ->groupBy('action')
            ->orderByDesc('nb')
            ->get()
            ->keyBy('action');

        return view('livewire.admin.journal-manager', compact('logs', 'actions'));
    }
}
