<?php

namespace App\Console\Commands;

use App\Models\Vendeur;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AdminCreateCommand extends Command
{
    protected $signature = 'admin:create {--email=} {--password=}';

    protected $description = 'Create or update the admin user';

    public function handle(): int
    {
        $email = $this->option('email');
        if (!$email) {
            $email = $this->ask('Admin email', 'admin@wifipourtous.com');
        }

        $password = $this->option('password');
        if (!$password) {
            $password = $this->secret('Admin password (min 6 characters)');
            if (!$password) {
                $this->error('Password is required.');
                return 1;
            }
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters.');
            return 1;
        }

        $admin = Vendeur::updateOrCreate(
            ['email' => $email],
            [
                'nom' => 'Admin',
                'prenom' => 'Raider',
                'is_admin' => true,
                'telephone' => '+22600000000',
                'password' => Hash::make($password),
                'statut' => 'actif',
                'commission_pct' => 10.00,
            ]
        );

        $this->info("Admin user created/updated successfully.");
        $this->line("Email: {$admin->email}");

        return 0;
    }
}
