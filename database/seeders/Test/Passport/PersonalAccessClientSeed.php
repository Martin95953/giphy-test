<?php

namespace Database\Seeders\Test\Passport;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalAccessClientSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = 'oauth_personal_access_clients';

        $data = [
            [
                'id' => 1,
                'client_id' => 1,
            ],
        ];

        DB::table($table)->insert($data);

    }
}
