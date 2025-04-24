<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TypeCulture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeCultureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_their_type_cultures()
    {
        $typeCulture = TypeCulture::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get('/type-culture');

        $response->assertStatus(200)
                ->assertViewHas('cultures')
                ->assertSee($typeCulture->libelle);
    }

    public function test_user_can_create_type_culture()
    {
        $response = $this->actingAs($this->user)->post('/type-culture', [
            'libelle' => 'Nouveau Type de Culture'
        ]);

        $response->assertRedirect('/type-culture');
        $this->assertDatabaseHas('type_cultures', [
            'libelle' => 'Nouveau Type de Culture',
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_cannot_create_duplicate_type_culture()
    {
        TypeCulture::factory()->create([
            'libelle' => 'Type Existant',
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->post('/type-culture', [
            'libelle' => 'Type Existant'
        ]);

        $response->assertSessionHasErrors('libelle');
    }

    public function test_user_can_update_their_type_culture()
    {
        $typeCulture = TypeCulture::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->put("/type-culture/{$typeCulture->id}", [
            'libelle' => 'Type Modifié'
        ]);

        $response->assertRedirect('/type-culture');
        $this->assertDatabaseHas('type_cultures', [
            'id' => $typeCulture->id,
            'libelle' => 'Type Modifié'
        ]);
    }

    public function test_user_cannot_update_other_users_type_culture()
    {
        $otherUser = User::factory()->create();
        $typeCulture = TypeCulture::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->put("/type-culture/{$typeCulture->id}", [
            'libelle' => 'Type Modifié'
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_type_culture()
    {
        $typeCulture = TypeCulture::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete("/type-culture/{$typeCulture->id}");

        $response->assertRedirect('/type-culture');
        $this->assertDatabaseMissing('type_cultures', ['id' => $typeCulture->id]);
    }

    public function test_user_cannot_delete_other_users_type_culture()
    {
        $otherUser = User::factory()->create();
        $typeCulture = TypeCulture::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->delete("/type-culture/{$typeCulture->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('type_cultures', ['id' => $typeCulture->id]);
    }
}
