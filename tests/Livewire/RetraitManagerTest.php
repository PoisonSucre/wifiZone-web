<?php

namespace Tests\Livewire;

use App\Http\Livewire\Vendor\RetraitManager;
use App\Models\Transaction;
use App\Models\Vendeur;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RetraitManagerTest extends TestCase
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
        ]);

        $this->actingAs($this->vendeur);
    }

    public function test_retrait_manager_renders(): void
    {
        Livewire::test(RetraitManager::class)
            ->assertStatus(200);
    }

    public function test_demander_retrait_creates_withdrawal(): void
    {
        Transaction::create([
            'vendeur_id' => $this->vendeur->id,
            'montant' => 5000,
            'statut' => 'completed',
            'commission' => 500,
            'token' => 'tok-1',
            'transaction_id' => 'TX-001',
        ]);

        Livewire::test(RetraitManager::class)
            ->set('montant', 2000)
            ->set('phoneNumber', '+22501010101')
            ->call('demanderRetrait')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('withdrawals', [
            'vendeur_id' => $this->vendeur->id,
            'montant_brut' => 2000,
            'phone_number' => '+22501010101',
            'statut' => 'pending',
        ]);
    }

    public function test_demander_retrait_validates_amount(): void
    {
        Livewire::test(RetraitManager::class)
            ->set('montant', 0)
            ->set('phoneNumber', '')
            ->call('demanderRetrait')
            ->assertHasErrors(['montant', 'phoneNumber']);
    }

    public function test_demander_retrait_rejects_insufficient_balance(): void
    {
        Livewire::test(RetraitManager::class)
            ->set('montant', 99999)
            ->set('phoneNumber', '+22501010101')
            ->call('demanderRetrait')
            ->assertSessionHas('error');
    }

    public function test_demander_retrait_computes_commission_correctly(): void
    {
        Transaction::create([
            'vendeur_id' => $this->vendeur->id,
            'montant' => 10000,
            'statut' => 'completed',
            'commission' => 1000,
            'token' => 'tok-1',
            'transaction_id' => 'TX-001',
        ]);

        Livewire::test(RetraitManager::class)
            ->set('montant', 5000)
            ->set('phoneNumber', '+22501010101')
            ->call('demanderRetrait');

        $withdrawal = Withdrawal::where('vendeur_id', $this->vendeur->id)->first();
        $this->assertEquals(5000, $withdrawal->montant_brut);
        $this->assertEquals(10, $withdrawal->commission_pct);
        $this->assertEquals(500, $withdrawal->montant_commission);
        $this->assertEquals(4500, $withdrawal->montant_net);
    }
}
