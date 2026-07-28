<?php

namespace Tests\Unit\Services;

use App\Models\Forfait;
use App\Models\Ticket;
use App\Models\Vendeur;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    use RefreshDatabase;

    private Vendeur $vendeur;
    private TicketService $service;

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

        $this->service = new TicketService();
    }

    public function test_assign_ticket_returns_ticket_when_available(): void
    {
        $ticket = Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'hotspot001',
            'password' => 'pass001',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'disponible',
        ]);

        $result = $this->service->assignTicket($this->vendeur->id, 500, 'token-abc');

        $this->assertNotNull($result);
        $this->assertEquals($ticket->id, $result->id);
        $this->assertEquals('vendu', $result->fresh()->status);
        $this->assertEquals('token-abc', $result->fresh()->token);
    }

    public function test_assign_ticket_returns_null_when_none_available(): void
    {
        $result = $this->service->assignTicket($this->vendeur->id, 500, 'token-abc');

        $this->assertNull($result);
    }

    public function test_assign_ticket_returns_null_when_wrong_montant(): void
    {
        Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'hotspot001',
            'password' => 'pass001',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'disponible',
        ]);

        $result = $this->service->assignTicket($this->vendeur->id, 1000, 'token-abc');

        $this->assertNull($result);
    }

    public function test_assign_ticket_skips_already_sold(): void
    {
        Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'hotspot001',
            'password' => 'pass001',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'vendu',
        ]);

        $result = $this->service->assignTicket($this->vendeur->id, 500, 'token-abc');

        $this->assertNull($result);
    }

    public function test_import_from_csv_creates_tickets(): void
    {
        $csv = "user;password;forfait;montant\nuser1;pass1;1h;500\nuser2;pass2;1h;500\n";
        $file = UploadedFile::fake()->createWithContent('test.csv', $csv);

        $result = $this->service->importFromCsv($this->vendeur->id, $file);

        $this->assertEquals(2, $result['created']);
        $this->assertEquals(0, $result['skipped']);
        $this->assertEquals(2, Ticket::where('vendeur_id', $this->vendeur->id)->count());
    }

    public function test_import_from_csv_skips_duplicates(): void
    {
        Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'user1',
            'password' => 'pass1',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'disponible',
        ]);

        $csv = "user;password;forfait;montant\nuser1;pass1;1h;500\nuser2;pass2;1h;500\n";
        $file = UploadedFile::fake()->createWithContent('test.csv', $csv);

        $result = $this->service->importFromCsv($this->vendeur->id, $file);

        $this->assertEquals(1, $result['created']);
        $this->assertEquals(1, $result['skipped']);
    }

    public function test_generate_batch_creates_tickets(): void
    {
        $forfait = Forfait::create([
            'vendeur_id' => $this->vendeur->id,
            'label' => '1h',
            'montant' => 500,
            'duree_minutes' => 60,
            'ordre' => 1,
        ]);

        $created = $this->service->generateBatch($this->vendeur->id, [
            'forfait_id' => $forfait->id,
            'count' => 10,
            'prefix' => 'WiFi-',
            'start_number' => 1,
            'pass_length' => 8,
        ]);

        $this->assertEquals(10, $created);
        $this->assertEquals(10, Ticket::where('vendeur_id', $this->vendeur->id)->count());
    }

    public function test_get_available_count(): void
    {
        Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'u1',
            'password' => 'p1',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'disponible',
        ]);
        Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'u2',
            'password' => 'p2',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'vendu',
        ]);

        $this->assertEquals(1, $this->service->getAvailableCount($this->vendeur->id));
    }

    public function test_get_sold_count(): void
    {
        Ticket::create([
            'vendeur_id' => $this->vendeur->id,
            'user' => 'u1',
            'password' => 'p1',
            'forfait' => '1h',
            'montant' => 500,
            'status' => 'vendu',
        ]);

        $this->assertEquals(1, $this->service->getSoldCount($this->vendeur->id));
    }
}
