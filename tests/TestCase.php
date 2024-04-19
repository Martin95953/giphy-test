<?php

namespace Tests;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected string $name = "John Doe";
    protected string $email = "test@test.com";
    protected string $password = "testPassword";

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        $this->artisan('db:seed');
    }

    protected function createUser(): User
    {
        return User::factory()->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password)
        ]);
    }
}
