<?php

namespace Tests\Livewire;

use App\Http\Livewire\Vendor\BoutiqueManager;
use App\Models\Forfait;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BoutiqueManagerTest extends TestCase
{
    use RefreshDatabase;

    private Vendeur $vendeur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vendeur = Vendeur::create([
            'nom' => 'Test',
            'prenom' => 'Vendor',
            'email' => 'vendor@test.com',
            'telephone' => '+22501010101',
            'password' => 'password123',
            'statut' => 'actif',
            'commission_pct' => 10,
            'couleur' => '#1ca04e',
        ]);

        $this->actingAs($this->vendeur);
    }

    public function test_boutique_manager_renders(): void
    {
        Livewire::test(BoutiqueManager::class)
            ->assertStatus(200);
    }

    public function test_add_forfait(): void
    {
        Livewire::test(BoutiqueManager::class)
            ->set('forfaitLabel', '1h')
            ->set('forfaitMontant', 500)
            ->set('forfaitDuree', 60)
            ->call('addForfait')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('vendor_forfaits', [
            'vendeur_id' => $this->vendeur->id,
            'label' => '1h',
            'montant' => 500,
            'duree_minutes' => 60,
        ]);
    }

    public function test_add_forfait_validates_required_fields(): void
    {
        Livewire::test(BoutiqueManager::class)
            ->set('forfaitLabel', '')
            ->set('forfaitMontant', 0)
            ->set('forfaitDuree', 0)
            ->call('addForfait')
            ->assertHasErrors(['forfaitLabel', 'forfaitMontant', 'forfaitDuree']);
    }

    public function test_edit_forfait_populates_fields(): void
    {
        $forfait = Forfait::create([
            'vendeur_id' => $this->vendeur->id,
            'label' => '2h',
            'montant' => 1000,
            'duree_minutes' => 120,
            'ordre' => 1,
        ]);

        Livewire::test(BoutiqueManager::class)
            ->call('editForfait', $forfait->id)
            ->assertSet('editingForfait', $forfait->id)
            ->assertSet('forfaitLabel', '2h')
            ->assertSet('forfaitMontant', 1000)
            ->assertSet('forfaitDuree', 120);
    }

    public function test_update_forfait(): void
    {
        $forfait = Forfait::create([
            'vendeur_id' => $this->vendeur->id,
            'label' => 'Old',
            'montant' => 100,
            'duree_minutes' => 30,
            'ordre' => 1,
        ]);

        Livewire::test(BoutiqueManager::class)
            ->call('editForfait', $forfait->id)
            ->set('forfaitLabel', 'Updated')
            ->set('forfaitMontant', 750)
            ->set('forfaitDuree', 90)
            ->call('updateForfait');

        $this->assertDatabaseHas('vendor_forfaits', [
            'id' => $forfait->id,
            'label' => 'Updated',
            'montant' => 750,
            'duree_minutes' => 90,
        ]);
    }

    public function test_toggle_forfait_actif(): void
    {
        $forfait = Forfait::create([
            'vendeur_id' => $this->vendeur->id,
            'label' => '1h',
            'montant' => 500,
            'duree_minutes' => 60,
            'actif' => true,
            'ordre' => 1,
        ]);

        Livewire::test(BoutiqueManager::class)
            ->call('toggleForfait', $forfait->id);

        $this->assertDatabaseHas('vendor_forfaits', [
            'id' => $forfait->id,
            'actif' => false,
        ]);
    }

    public function test_delete_forfait(): void
    {
        $forfait = Forfait::create([
            'vendeur_id' => $this->vendeur->id,
            'label' => 'ToDelete',
            'montant' => 500,
            'duree_minutes' => 60,
            'ordre' => 1,
        ]);

        Livewire::test(BoutiqueManager::class)
            ->call('confirmDelete', $forfait->id)
            ->assertSet('showDeleteModal', true)
            ->call('deleteForfait')
            ->assertSet('showDeleteModal', false);

        $this->assertDatabaseMissing('vendor_forfaits', ['id' => $forfait->id]);
    }

    public function test_update_shop_message(): void
    {
        Livewire::test(BoutiqueManager::class)
            ->set('messageBienvenue', 'Bienvenue chez nous!')
            ->set('couleur', '#ff0000')
            ->call('updateShop');

        $this->vendeur->refresh();
        $this->assertEquals('Bienvenue chez nous!', $this->vendeur->message_bienvenue);
        $this->assertEquals('#ff0000', $this->vendeur->couleur);
    }
}
