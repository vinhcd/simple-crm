<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrganizationUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'neos',
            'email' => 'neos@neoscorp.vn',
            'password' => Hash::make('neos'),
            'role_id' => 1,
        ]);
    }
}
