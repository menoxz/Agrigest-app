<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $adminRole = Role::firstOrCreate(['nom_role' => 'admin'], ['description' => 'Rôle administrateur']);
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->userRole = Role::firstOrCreate(['nom_role' => 'agriculteur'], ['description' => 'Rôle utilisateur']);
    }

    public function test_admin_can_view_users_list()
    {
        $user = User::factory()->create(['role_id' => $this->userRole->id]);

        $response = $this->actingAs($this->admin)->get('/admin/users');

        $response->assertStatus(200)
                ->assertViewHas('users')
                ->assertSee($user->name);
    }

    public function test_admin_can_create_user()
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Nouvel Utilisateur',
            'email' => 'nouvel@example.com',
            'password' => 'Password123!',
            'role_id' => $this->userRole->id
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'name' => 'Nouvel Utilisateur',
            'email' => 'nouvel@example.com',
            'role_id' => $this->userRole->id
        ]);
    }

    public function test_admin_can_edit_user()
    {
        $user = User::factory()->create(['role_id' => $this->userRole->id]);

        $response = $this->actingAs($this->admin)->put("/admin/users/{$user->id}", [
            'name' => 'Utilisateur Modifié',
            'email' => 'modifie@example.com',
            'role_id' => $this->userRole->id
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Utilisateur Modifié',
            'email' => 'modifie@example.com'
        ]);
    }

    public function test_admin_can_toggle_user_status()
    {
        $user = User::factory()->create([
            'role_id' => $this->userRole->id,
            'status' => true
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/users/{$user->id}/toggle-status");

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => false
        ]);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create(['role_id' => $this->userRole->id]);

        $response = $this->actingAs($this->admin)->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $response = $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $user = User::factory()->create(['role_id' => $this->userRole->id]);

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertRedirect();
    }
}
