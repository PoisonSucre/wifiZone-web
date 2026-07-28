<?php

namespace Tests\Livewire;

use App\Http\Livewire\Admin\VendeurManager;
use App\Models\Setting;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VendeurManagerTest extends TestCase
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

    public function test_vendeur_manager_renders(): void
    {
        Livewire::test(VendeurManager::class)
            ->assertStatus(200);
    }

    public function test_activate_vendeur(): void
    {
        $vendor = Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'pass',
            'statut' => 'en_attente',
            'commission_pct' => 10,
        ]);

        Livewire::test(VendeurManager::class)
            ->call('activate', $vendor->id);

        $this->assertDatabaseHas('vendeurs', [
            'id' => $vendor->id,
            'statut' => 'actif',
        ]);
    }

    public function test_suspend_vendeur(): void
    {
        $vendor = Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(VendeurManager::class)
            ->call('suspend', $vendor->id);

        $this->assertDatabaseHas('vendeurs', [
            'id' => $vendor->id,
            'statut' => 'suspendu',
        ]);
    }

    public function test_delete_vendeur(): void
    {
        $vendor = Vendeur::create([
            'nom' => 'ToDelete',
            'prenom' => 'User',
            'email' => 'delete@test.com',
            'telephone' => '+22501010101',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(VendeurManager::class)
            ->call('delete', $vendor->id);

        $this->assertDatabaseMissing('vendeurs', ['id' => $vendor->id]);
    }

    public function test_add_vendeur(): void
    {
        Livewire::test(VendeurManager::class)
            ->set('showAddModal', true)
            ->set('newNom', 'Nouveau')
            ->set('newPrenom', 'Vendeur')
            ->set('newEmail', 'nouveau@test.com')
            ->set('newTelephone', '+22501010101')
            ->set('newPassword', 'secret123')
            ->set('newCommission', 15)
            ->call('addVendeur')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('vendeurs', [
            'email' => 'nouveau@test.com',
            'statut' => 'actif',
            'commission_pct' => 15,
        ]);
    }

    public function test_add_vendeur_validates_required_fields(): void
    {
        Livewire::test(VendeurManager::class)
            ->set('newNom', '')
            ->set('newPrenom', '')
            ->set('newEmail', '')
            ->set('newTelephone', '')
            ->set('newPassword', '')
            ->call('addVendeur')
            ->assertHasErrors(['newNom', 'newPrenom', 'newEmail', 'newTelephone', 'newPassword']);
    }

    public function test_save_commission(): void
    {
        $vendor = Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(VendeurManager::class)
            ->call('openCommissionModal', $vendor->id, 10.0)
            ->set('editingCommissionValue', 20.0)
            ->call('saveCommission');

        $this->assertDatabaseHas('vendeurs', [
            'id' => $vendor->id,
            'commission_pct' => 20.0,
        ]);
    }

    public function test_search_filters_vendeurs(): void
    {
        Vendeur::create([
            'nom' => 'Alpha',
            'prenom' => 'One',
            'email' => 'alpha@test.com',
            'telephone' => '+22501010101',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Vendeur::create([
            'nom' => 'Beta',
            'prenom' => 'Two',
            'email' => 'beta@test.com',
            'telephone' => '+22502020202',
            'password' => 'pass',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(VendeurManager::class)
            ->set('search', 'Alpha')
            ->call('render')
            ->assertSee('Alpha')
            ->assertDontSee('Beta');
    }
}
