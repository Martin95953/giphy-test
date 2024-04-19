<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    public function test_user_cannot_register_invalid_email()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => $this->name,
            'email' => 'testtest.com',
            'password' => $this->password
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(201);
    }

    public function test_user_cannot_register_duplicated()
    {

        $user = $this->createUser();

        $response = $this->postJson('/api/v1/register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password]);

        $response->assertStatus(422);
    }

    public function test_user_cannot_login_with_incorrect_credentials()
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/v1/login', [
            'email' => 'testfail123@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/v1/login', [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_logout()
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;

        // Hacer la petición POST al endpoint de logout con el token en el header de autorización
        $response = $this->post('/api/v1/logout', [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_cannot_logout_without_token()
    {
        $response = $this->post('/api/v1/logout');
        $response->assertStatus(401);
    }


}
