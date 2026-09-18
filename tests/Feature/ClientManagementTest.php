<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_clients(): void
    {
        $user = User::factory()->create();

        Client::factory()->create([
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria@example.com',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->get('/clients');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Maria Santos Consulting LLC',
        ]);
    }

    public function test_guest_cannot_access_clients(): void
    {
        $response = $this->get('/clients');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_a_client(): void
    {
        $user = User::factory()->create();

        $clientData = [
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria@example.com',
            'phone' => '09171234567',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ];

        $response = $this->actingAs($user)->postJson('/clients', $clientData);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'Client created successfully.',
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria@example.com',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);
    }

    public function test_client_creation_requires_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/clients', []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'entity_type',
            'status',
        ]);
    }

    public function test_client_creation_rejects_invalid_email(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/clients', [
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'not-an-email',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'email',
        ]);
    }

    public function test_client_creation_rejects_invalid_entity_type(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/clients', [
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria@example.com',
            'entity_type' => 'Invalid Type',
            'status' => 'Active',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'entity_type',
        ]);
    }

    public function test_authenticated_user_can_update_a_client(): void
    {
        $user = User::factory()->create();

        $client = Client::factory()->create([
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria@example.com',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->putJson("/clients/{$client->id}", [
            'name' => 'Maria Santos Consulting',
            'email' => 'updated@example.com',
            'phone' => '09991234567',
            'entity_type' => 'LLC',
            'status' => 'Inactive',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Client updated successfully.',
        ]);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Maria Santos Consulting',
            'email' => 'updated@example.com',
            'status' => 'Inactive',
        ]);
    }

    public function test_authenticated_user_can_archive_a_client(): void
    {
        $user = User::factory()->create();

        $client = Client::factory()->create([
            'name' => 'Maria Santos Consulting LLC',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->deleteJson("/clients/{$client->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Client archived successfully.',
        ]);

        $this->assertSoftDeleted('clients', [
            'id' => $client->id,
        ]);
    }

    public function test_client_list_can_be_searched_by_name(): void
    {
        $user = User::factory()->create();

        Client::factory()->create([
            'name' => 'Maria Santos Consulting LLC',
            'email' => 'maria@example.com',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);

        Client::factory()->create([
            'name' => 'Juan Dela Cruz Corporation',
            'email' => 'juan@example.com',
            'entity_type' => 'Corporation',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->getJson('/clients?search=Maria');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => 'Maria Santos Consulting LLC',
        ]);

        $response->assertJsonMissing([
            'name' => 'Juan Dela Cruz Corporation',
        ]);
    }

    public function test_client_list_can_be_filtered_by_status(): void
    {
        $user = User::factory()->create();

        Client::factory()->create([
            'name' => 'Active Client',
            'entity_type' => 'LLC',
            'status' => 'Active',
        ]);

        Client::factory()->create([
            'name' => 'Inactive Client',
            'entity_type' => 'Corporation',
            'status' => 'Inactive',
        ]);

        $response = $this->actingAs($user)->getJson('/clients?status=Inactive');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => 'Inactive Client',
        ]);

        $response->assertJsonMissing([
            'name' => 'Active Client',
        ]);
    }
}
