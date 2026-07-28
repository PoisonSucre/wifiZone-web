<?php

namespace Tests\Feature;

use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_component_renders(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->assertStatus(200);
    }

    public function test_login_with_valid_credentials(): void
    {
        $vendeur = Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'secret123',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->set('email', 'jean@test.com')
            ->set('password', 'secret123')
            ->call('login')
            ->assertRedirect(route('vendor.dashboard'));

        $this->assertAuthenticatedAs($vendeur);
    }

    public function test_login_with_wrong_password(): void
    {
        Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'secret123',
            'statut' => 'actif',
            'commission_pct' => 10,
        ]);

        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->set('email', 'jean@test.com')
            ->set('password', 'wrongpassword')
            ->call('login')
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_login_with_nonexistent_user(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->set('email', 'nonexistent@test.com')
            ->set('password', 'password')
            ->call('login')
            ->assertNoRedirect();
    }

    public function test_login_with_pending_account(): void
    {
        Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'secret123',
            'statut' => 'en_attente',
            'commission_pct' => 10,
        ]);

        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->set('email', 'jean@test.com')
            ->set('password', 'secret123')
            ->call('login')
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_login_with_suspended_account(): void
    {
        Vendeur::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean@test.com',
            'telephone' => '+22501010101',
            'password' => 'secret123',
            'statut' => 'suspendu',
            'commission_pct' => 10,
        ]);

        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->set('email', 'jean@test.com')
            ->set('password', 'secret123')
            ->call('login')
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_login_validates_required_fields(): void
    {
        Livewire::test(\App\Http\Livewire\Auth\LoginForm::class)
            ->set('email', '')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors(['email', 'password']);
    }
}
