<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('User can register with valid data', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password1234',
        'confirm_password' => 'password1234',
        'device_name' => 'Test Device',
        'location' => '127.0.0.1',
    ];

    $response = $this->postJson('/api/register', $data);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', ['email' => $data['email']]);
});

test('User cannot register with mismatched passwords', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password1234',
        'confirm_password' => 'wrongpassword',
        'device_name' => 'Test Device',
        'location' => '127.0.0.1',
    ];

    $response = $this->postJson('/api/register', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('confirm_password');
});

test('User can log in with valid credentials', function () {
    User::factory()->create([
        'email' => 'john.doe@example.com',
        'password' => Hash::make('password1234'),
    ]);

    $data = [
        'email' => 'john.doe@example.com',
        'password' => 'password1234',
        'device_name' => 'Test Device',
        'location' => '127.0.0.1',
    ];

    $response = $this->postJson('/api/login', $data);

    $response->assertStatus(200);
    $response->assertJsonStructure(['token']);
});

test('User cannot log in with invalid credentials', function () {
    User::factory()->create([
        'email' => 'john.doe@example.com',
        'password' => Hash::make('password1234'),
    ]);

    $data = [
        'email' => 'john.doe@example.com',
        'password' => 'wrongpassword',
        'device_name' => 'Test Device',
        'location' => '127.0.0.1',
    ];

    $response = $this->postJson('/api/login', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('password');
});
