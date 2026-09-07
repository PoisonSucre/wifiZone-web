<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'ranihamedt@gmail.com'],
            [
                'nom' => 'Admin',
                'prenom' => 'Raider',
                'password' => bcrypt('password'),
            ]
        );

        $this->command->info('Admin seeded: ranihamedt@gmail.com / password');
    }
}
