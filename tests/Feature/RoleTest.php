<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Root user can create a role', function () {
    $root = User::factory()->withRole('root')->create();

    $data = ['name' => 'Admin'];

    $response = $this->actingAs($root, 'sanctum')
        ->postJson('/api/roles', $data);

    $response->assertStatus(200);
    $this->assertDatabaseHas('roles', ['name' => 'Admin']);
});

test('Non-root user cannot create a role', function () {
    $user = User::factory()->create();

    $data = ['name' => 'Admin'];

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/roles', $data);

    $response->assertStatus(403);
});

test('Root user can view all roles', function () {
    $root = User::factory()->withRole('root')->create();
    Role::factory(3)->create();

    $response = $this->actingAs($root, 'sanctum')
        ->getJson('/api/roles');

    $response->assertStatus(200);
    $this->assertCount(4, $response->json()); // Root + 3 custom roles
});

test('Root user can update a role', function () {
    $root = User::factory()->withRole('root')->create();
    $role = Role::factory()->create(['name' => 'Admin']);

    $data = ['name' => 'Super Admin'];

    $response = $this->actingAs($root, 'sanctum')
        ->putJson('/api/roles/' . $role->uuid, $data);

    $response->assertStatus(200);
    $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);
});

test('Root user can delete a role', function () {
    $root = User::factory()->withRole('root')->create();
    $role = Role::factory()->create();

    $response = $this->actingAs($root, 'sanctum')
        ->deleteJson('/api/roles/' . $role->uuid);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

