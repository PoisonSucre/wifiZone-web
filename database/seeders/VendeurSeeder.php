<?php

namespace Database\Seeders;

use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendeurSeeder extends Seeder
{
    public function run(): void
    {
        Vendeur::updateOrCreate(
            ['email' => 'amadou@test.com'],
            [
                'nom' => 'Diallo',
                'prenom' => 'Amadou',
                'telephone' => '+22607123456',
                'password' => 'password',
                'statut' => 'actif',
                'commission_pct' => 5.00,
            ]
        );

        Vendeur::updateOrCreate(
            ['email' => 'fatima@test.com'],
            [
                'nom' => 'Ouédraogo',
                'prenom' => 'Fatima',
                'telephone' => '+22607987654',
                'password' => 'password',
                'statut' => 'actif',
                'commission_pct' => 15.00,
            ]
        );

        Vendeur::updateOrCreate(
            ['email' => 'ibrahim@test.com'],
            [
                'nom' => 'Kaboré',
                'prenom' => 'Ibrahim',
                'telephone' => '+22607555123',
                'password' => 'password',
                'statut' => 'actif',
                'commission_pct' => 8.00,
            ]
        );

        Vendeur::updateOrCreate(
            ['email' => 'aissatou@test.com'],
            [
                'nom' => 'Sawadogo',
                'prenom' => 'Aissatou',
                'telephone' => '+22607111222',
                'password' => 'password',
                'statut' => 'en_attente',
                'commission_pct' => 10.00,
            ]
        );

        Vendeur::updateOrCreate(
            ['email' => 'moussa@test.com'],
            [
                'nom' => 'Compaoré',
                'prenom' => 'Moussa',
                'telephone' => '+22607333444',
                'password' => 'password',
                'statut' => 'en_attente',
                'commission_pct' => 12.00,
            ]
        );

        Vendeur::updateOrCreate(
            ['email' => 'ranihamedt@gmail.com'],
            [
                'nom' => 'Hamed',
                'prenom' => 'Rani',
                'telephone' => '+22607777888',
                'password' => 'password',
                'statut' => 'actif',
                'commission_pct' => 10.00,
                'email_verified_at' => now(),
            ]
        );

        Vendeur::updateOrCreate(
            ['email' => 'salimata@test.com'],
            [
                'nom' => 'Touré',
                'prenom' => 'Salimata',
                'telephone' => '+22607555666',
                'password' => 'password',
                'statut' => 'suspendu',
                'commission_pct' => 7.00,
            ]
        );
    }
}
