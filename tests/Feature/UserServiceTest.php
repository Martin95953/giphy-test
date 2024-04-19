<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_can_show_user(): void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->get("/api/v1/users/{$user->id}");
        $response->assertStatus(200);
    }

    public function test_cannot_show_user_if_doesnot_exist(): void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->get("/api/v1/users/99");
        $response->assertStatus(404);
    }

    public function test_can_list_all_users(): void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->get("/api/v1/users/");
        $response->assertStatus(200);
    }
}
