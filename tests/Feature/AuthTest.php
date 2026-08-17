<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(201)->assertJsonStructure(['user' => ['id', 'name', 'email']]);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_login_and_get_user()
    {
        $user = User::create([
            'name' => 'Login User',
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);

        $login = $this->postJson('/api/auth/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $login->assertStatus(200)->assertJsonStructure(['user' => ['id', 'name', 'email']]);

        // After login, call user endpoint
        $userResp = $this->getJson('/api/auth/user');
        $userResp->assertStatus(200)->assertJsonPath('user.email', 'login@example.com');
    }

    public function test_logout_revokes_session()
    {
        $user = User::create([
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Login to establish session
        $login = $this->postJson('/api/auth/login', [
            'email' => 'logout@example.com',
            'password' => 'password123',
        ]);
        $login->assertStatus(200);

        $resp = $this->postJson('/api/auth/logout');
        $resp->assertStatus(200);
    }
}
