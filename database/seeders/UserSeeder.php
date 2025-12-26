<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'=>'Admin',
                'email'=>'admin@test.com',
                'password'=>Hash::make('password'),
                'role'=>'admin',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'name'=>'User',
                'email'=>'user@test.com',
                'password'=>Hash::make('password'),
                'role'=>'user',
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
             [
                'name'=>'sonu',
                'email'=>'sonu@test.com',
                'password'=>Hash::make('sonu'),
                'role'=>'user',
                'created_at'=>now(),
                'updated_at'=>now(),
            ]
        ]);
    }
}