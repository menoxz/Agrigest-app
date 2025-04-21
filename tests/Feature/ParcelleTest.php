<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Parcelle;
use App\Models\TypeCulture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParcelleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->typeCulture = TypeCulture::factory()->create([
            'libelle' => 'Test Culture',
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_can_view_their_parcelles()
    {
        $parcelle = Parcelle::factory()->create([
            'user_id' => $this->user->id,
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response = $this->actingAs($this->user)->get('/parcelle');

        $response->assertStatus(200)
                ->assertViewHas('parcelles')
                ->assertSee($parcelle->nom_parcelle);
    }

    public function test_user_can_create_parcelle()
    {
        $response = $this->actingAs($this->user)->post('/parcelle', [
            'nom_parcelle' => 'Nouvelle Parcelle',
            'superficie' => 10.5,
            'date_plantation' => '2024-01-01',
            'statut' => 'En culture',
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response->assertRedirect('/parcelle');
        $this->assertDatabaseHas('parcelles', [
            'nom_parcelle' => 'Nouvelle Parcelle',
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_cannot_create_parcelle_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->post('/parcelle', [
            'nom_parcelle' => '',
            'superficie' => 'invalid',
            'type_culture_id' => 999
        ]);

        $response->assertSessionHasErrors(['nom_parcelle', 'superficie', 'type_culture_id']);
    }

    public function test_user_can_update_their_parcelle()
    {
        $parcelle = Parcelle::factory()->create([
            'user_id' => $this->user->id,
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response = $this->actingAs($this->user)->put("/parcelle/{$parcelle->id}", [
            'nom_parcelle' => 'Parcelle Modifiée',
            'superficie' => 15.5,
            'date_plantation' => '2024-02-01',
            'statut' => 'Récoltée',
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response->assertRedirect('/parcelle');
        $this->assertDatabaseHas('parcelles', [
            'id' => $parcelle->id,
            'nom_parcelle' => 'Parcelle Modifiée'
        ]);
    }

    public function test_user_cannot_update_other_users_parcelle()
    {
        $otherUser = User::factory()->create();
        $parcelle = Parcelle::factory()->create([
            'user_id' => $otherUser->id,
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response = $this->actingAs($this->user)->put("/parcelle/{$parcelle->id}", [
            'nom_parcelle' => 'Parcelle Modifiée',
            'superficie' => 15.5,
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_parcelle()
    {
        $parcelle = Parcelle::factory()->create([
            'user_id' => $this->user->id,
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response = $this->actingAs($this->user)->delete("/parcelle/{$parcelle->id}");

        $response->assertRedirect('/parcelle');
        $this->assertDatabaseMissing('parcelles', ['id' => $parcelle->id]);
    }

    public function test_user_cannot_delete_other_users_parcelle()
    {
        $otherUser = User::factory()->create();
        $parcelle = Parcelle::factory()->create([
            'user_id' => $otherUser->id,
            'type_culture_id' => $this->typeCulture->id
        ]);

        $response = $this->actingAs($this->user)->delete("/parcelle/{$parcelle->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('parcelles', ['id' => $parcelle->id]);
    }
}
