<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminLog;
use Livewire\Component;
use Livewire\WithPagination;

class JournalManager extends Component
{
    use WithPagination;

    public string $filterAction = '';

    protected $queryString = ['filterAction' => ['except' => '']];

    public function render()
    {
        $query = AdminLog::with('admin')->orderByDesc('created_at');
        if ($this->filterAction) {
            $query->where('action', $this->filterAction);
        }

        $logs = $query->paginate(25);

        $actions = AdminLog::query()
            ->selectRaw('action, COUNT(*) as nb')
            ->groupBy('action')
            ->orderByDesc('nb')
            ->get()
            ->keyBy('action');

        return view('livewire.admin.journal-manager', compact('logs', 'actions'));
    }
}
