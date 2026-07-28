<?php

namespace Tests\Livewire;

use App\Http\Livewire\Admin\Dashboard;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Vendeur;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private Vendeur $admin;

    protected function setUp(): void
    {
        parent::setUp();

        config(['platform.admin.email' => 'admin@test.com']);
        Setting::set('admin_email', 'admin@test.com');

        $this->admin = Vendeur::create([
            'nom' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@test.com',
            'telephone' => '+22500000000',
            'password' => 'admin123',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        $this->actingAs($this->admin);
    }

    public function test_admin_dashboard_renders(): void
    {
        Livewire::test(Dashboard::class)
            ->assertStatus(200);
    }

    public function test_dashboard_counts_vendeurs_excluding_admin(): void
    {
        Vendeur::create([
            'nom' => 'Vendor1',
            'prenom' => 'One',
            'email' => 'v1@test.com',
            'telephone' => '+22501010101',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(Dashboard::class)
            ->assertSet('totalVendeurs', 1)
            ->assertSet('vendeursActifs', 1);
    }

    public function test_dashboard_counts_pending_vendeurs(): void
    {
        Vendeur::create([
            'nom' => 'Pending',
            'prenom' => 'User',
            'email' => 'pending@test.com',
            'telephone' => '+22502020202',
            'password' => 'pass',
            'statut' => 'en_attente',
            'commission_pct' => 10,
        ]);

        Livewire::test(Dashboard::class)
            ->assertSet('vendeursEnAttente', 1);
    }

    public function test_dashboard_counts_tickets(): void
    {
        $vendor = Vendeur::create([
            'nom' => 'V',
            'prenom' => 'Endor',
            'email' => 'vendor@test.com',
            'telephone' => '+22503030303',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Ticket::create([
            'vendeur_id' => $vendor->id,
            'user' => 'u1',
            'password' => 'p1',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'disponible',
        ]);
        Ticket::create([
            'vendeur_id' => $vendor->id,
            'user' => 'u2',
            'password' => 'p2',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'vendu',
        ]);

        Livewire::test(Dashboard::class)
            ->assertSet('totalTickets', 2)
            ->assertSet('ticketsVendus', 1);
    }

    public function test_dashboard_counts_pending_withdrawals(): void
    {
        $vendor = Vendeur::create([
            'nom' => 'V',
            'prenom' => 'Endor',
            'email' => 'vendor@test.com',
            'telephone' => '+22503030303',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Withdrawal::create([
            'vendeur_id' => $vendor->id,
            'montant_brut' => 3000,
            'commission_pct' => 10,
            'montant_commission' => 300,
            'montant_net' => 2700,
            'statut' => 'pending',
        ]);

        Livewire::test(Dashboard::class)
            ->assertSet('nbRetraitsEnCours', 1);
    }
}
