<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        DB::table('group')->insert([
            'name' => 'superadmin',
            'priority' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'neos',
            'email' => 'neos@neoscorp.vn',
            'password' => Hash::make('neos'),
        ]);
        DB::table('user_group')->insert([
            'user_id' => 1,
            'group_id' => 1
        ]);

        DB::commit();
    }
}
