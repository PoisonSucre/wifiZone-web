<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public array $messages = [];

    protected static int $counter = 0;

    protected $listeners = [
        'toast'        => 'add',
        'remove-toast' => 'remove',
    ];

    public function add(string $type, string $message, ?int $duration = 4000): void
    {
        self::$counter++;
        $id = 'toast-' . self::$counter;

        $this->messages[] = [
            'id'       => $id,
            'type'     => $type,
            'message'  => $message,
            'duration' => $duration,
        ];
    }

    public function remove(string $id): void
    {
        $this->messages = array_values(
            array_filter($this->messages, static fn(array $m): bool => $m['id'] !== $id)
        );
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
