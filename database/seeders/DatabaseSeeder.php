<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Test\Passport\ClientSeed;
use Database\Seeders\Test\Passport\PersonalAccessClientSeed;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClientSeed::class,
            PersonalAccessClientSeed::class
        ]);
    }
}
