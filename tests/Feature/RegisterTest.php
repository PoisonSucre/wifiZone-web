<?php

namespace Tests\Feature;

use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_component_renders(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->assertStatus(200);
    }

    public function test_register_creates_vendeur_with_pending_status(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->set('step', 1)
            ->set('nom', 'Dupont')
            ->set('prenom', 'Jean')
            ->call('nextStep')
            ->assertSet('step', 2)
            ->set('email', 'jean@test.com')
            ->set('telephone', '+22501010101')
            ->call('nextStep')
            ->assertSet('step', 3)
            ->set('password', 'secret123')
            ->set('passwordConfirmation', 'secret123')
            ->call('register')
            ->assertRedirect(route('vendor.pending'));

        $this->assertDatabaseHas('vendeurs', [
            'email' => 'jean@test.com',
            'statut' => 'en_attente',
        ]);
    }

    public function test_register_step1_requires_nom_and_prenom(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->set('nom', '')
            ->set('prenom', '')
            ->call('nextStep')
            ->assertHasErrors(['nom', 'prenom']);
    }

    public function test_register_step2_requires_valid_email(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->set('step', 2)
            ->set('email', 'not-an-email')
            ->set('telephone', '')
            ->call('nextStep')
            ->assertHasErrors(['email', 'telephone']);
    }

    public function test_register_step2_rejects_duplicate_email(): void
    {
        Vendeur::create([
            'nom' => 'Existing',
            'prenom' => 'User',
            'email' => 'taken@test.com',
            'telephone' => '+22501010101',
            'password' => 'secret123',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->set('step', 2)
            ->set('email', 'taken@test.com')
            ->set('telephone', '+22501010101')
            ->call('nextStep')
            ->assertHasErrors(['email']);
    }

    public function test_register_step3_requires_password_confirmation(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->set('step', 3)
            ->set('password', 'short')
            ->set('passwordConfirmation', 'different')
            ->call('register')
            ->assertHasErrors(['password']);
    }

    public function test_register_step3_requires_min_password_length(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\RegisterForm::class)
            ->set('step', 3)
            ->set('password', '12345')
            ->set('passwordConfirmation', '12345')
            ->call('register')
            ->assertHasErrors(['password']);
    }
}
