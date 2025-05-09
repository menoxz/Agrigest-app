<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\TypeCulture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeCultureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un rôle admin
        $roleAdmin = Role::firstOrCreate(
            ['nom_role' => 'admin'],
            ['description' => 'Administrateur du système']
        );

        // Créer un utilisateur admin
        $this->admin = User::factory()->create([
            'role_id' => $roleAdmin->id
        ]);

        // Créer un utilisateur normal
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_their_type_cultures()
    {
        $typeCulture = TypeCulture::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->get('/admin/type-cultures');

        $response->assertStatus(200);
    }

    public function test_user_can_create_type_culture()
    {
        $response = $this->actingAs($this->admin)->post('/admin/type-cultures', [
            'libelle' => 'Nouveau Type de Culture'
        ]);

        $response->assertRedirect('/admin/type-cultures');
        $this->assertDatabaseHas('type_cultures', [
            'libelle' => 'Nouveau Type de Culture'
        ]);
    }

    public function test_user_cannot_create_duplicate_type_culture()
    {
        TypeCulture::factory()->create([
            'libelle' => 'Type Existant',
            'user_id' => $this->admin->id
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/type-cultures', [
            'libelle' => 'Type Existant'
        ]);

        $response->assertSessionHasErrors('libelle');
    }

    public function test_user_can_update_their_type_culture()
    {
        $typeCulture = TypeCulture::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->put("/admin/type-cultures/{$typeCulture->id}", [
            'libelle' => 'Type Modifié'
        ]);

        $response->assertRedirect('/admin/type-cultures');
        $this->assertDatabaseHas('type_cultures', [
            'id' => $typeCulture->id,
            'libelle' => 'Type Modifié'
        ]);
    }

    public function test_non_admin_cannot_access_type_culture()
    {
        $response = $this->actingAs($this->user)->get('/admin/type-cultures');
        $response->assertStatus(302); // Redirection pour les non-admins
    }

    public function test_user_can_delete_their_type_culture()
    {
        $typeCulture = TypeCulture::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->delete("/admin/type-cultures/{$typeCulture->id}");

        $response->assertRedirect('/admin/type-cultures');
        $this->assertDatabaseMissing('type_cultures', ['id' => $typeCulture->id]);
    }

    public function test_admin_can_view_creation_form()
    {
        $response = $this->actingAs($this->admin)->get('/admin/type-cultures/create');
        $response->assertStatus(200);
    }
}
