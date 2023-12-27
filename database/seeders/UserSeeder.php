<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'      => 'Admin',
            'email'     => 'admin@123',
            'password'  => Hash::make('123'),
            'role'      => 'admin',
        ]);

        DB::table('users')->insert([
            'name'      => 'IT Support',
            'email'     => 'it@123',
            'password'  => Hash::make('123'),
            'role'      => 'it',
        ]);
    }
}
