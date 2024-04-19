<?php

namespace Database\Seeders\Test\Passport;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = 'oauth_clients';

        $data = [
            [
                'id' => 1,
                'user_id' => null,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'xYQiYwCb82QJgs0HFvuARo2xStYwDz6XPXcVRj00',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2024-04-18 13:44:57',
                'updated_at' => '2024-04-18 13:44:57',
            ],
            [
                'id' => 2,
                'user_id' => null,
                'name' => 'Laravel Password Grant Client',
                'secret' => 'SUrZ0B7oFSqSBOszCutLOrEiaS8bbXJAMbw2BBBD',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2024-04-18 13:44:57',
                'updated_at' => '2024-04-18 13:44:57',
            ],
        ];

        DB::table($table)->insert($data);

    }
}
