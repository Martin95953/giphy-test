<?php

namespace Tests\Feature;

use App\Models\Gif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GifServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_search_gif(): void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);

        $response = $this->get('/api/v1/gifs/search?query=dog&limit=5&offset=0');

        $response->assertStatus(200);
    }

    public function test_cannot_search_gif_because_argument_too_long(): void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);

        $response = $this->get('/api/v1/gifs/search?query=a2s1d32as1d32as1@@@d32as1d32as1d32as1d32a1sd23as132d1&limit=5&offset=0');

        $response->assertStatus(414);
    }

    public function test_can_show_gif() : void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);

        $response = $this->get('/api/v1/gifs/xUPGcpfvIsVNeOAZgI');

        $response->assertStatus(200);
    }

    public function test_cannot_show_gif_because_not_exist() : void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);

        $response = $this->get('/api/v1/gifs/xUPGcpfvIsVNeOXXxx');

        $response->assertStatus(404);
    }

    public function test_can_save_gif_to_favorites() : void
    {
        $user = $this->createUser();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);

        $response = $this->postJson('/api/v1/gifs', [
            'gif_id' => 'xUPGcpfvIsVNeOAZgI',
            'alias' => 'dog',
            'user_id' => $user->id
        ]);

        $response->assertStatus(201);
    }

    public function test_cannot_save_duplicated_gif_to_same_user() : void
    {
        $user = $this->createUser();

        $gif = new Gif();
        $gif->gif_id = 'xUPGcpfvIsVNeOAZgI';
        $gif->alias = 'dog';
        $gif->user_id = $user->id;
        $gif->save();

        $token = $user->createToken('Personal Access Token')->accessToken;
        $this->withHeaders(['Authorization' => "Bearer $token"]);

        $response = $this->postJson('/api/v1/gifs', [
            'gif_id' => 'xUPGcpfvIsVNeOAZgI',
            'alias' => 'dog',
            'user_id' => $user->id
        ]);

        $response->assertStatus(422);
    }
}
