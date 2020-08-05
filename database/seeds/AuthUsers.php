<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@neoscorp.vn',
            'password' => Hash::make('neos@123!'),
            'role_id' => 1,
        ]);

        DB::table('role')->insert([
            'name' => 'superuser',
            'priority' => 1,
        ]);
    }
}
