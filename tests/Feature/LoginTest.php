<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_tokens_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',

        ]);
    }

    public function test_login_returns_errors_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'noneexistent@user.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }
}
