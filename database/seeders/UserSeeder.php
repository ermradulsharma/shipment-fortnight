<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'roleid' => 1,
            'name' => 'Admin',
            'phone' => '7078049692',
            'city' => 'Agra',
            'state' => 'UP',
            'country' => 'India',
            'pin' => '282001',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
