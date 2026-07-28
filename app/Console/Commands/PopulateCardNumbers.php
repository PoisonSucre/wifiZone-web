<?php

namespace App\Console\Commands;

use App\Models\Vendeur;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PopulateCardNumbers extends Command
{
    protected $signature = 'vendeurs:populate-card-numbers';
    protected $description = 'Populate missing card numbers for vendors';

    public function handle()
    {
        $vendeurs = Vendeur::whereNull('card_number')->get();
        $count = 0;

        foreach ($vendeurs as $vendeur) {
            $vendeur->card_number = $this->generateUniqueCardNumber();
            $vendeur->save();
            $count++;
        }

        $this->info("{$count} vendors updated with card numbers.");
    }

    private function generateUniqueCardNumber(): string
    {
        do {
            // Generate 16 digits
            $number = substr(str_shuffle("0123456789"), 0, 4) . '-' . 
                      substr(str_shuffle("0123456789"), 0, 4) . '-' . 
                      substr(str_shuffle("0123456789"), 0, 4) . '-' . 
                      substr(str_shuffle("0123456789"), 0, 4);
        } while (Vendeur::where('card_number', $number)->exists());

        return $number;
    }
}
