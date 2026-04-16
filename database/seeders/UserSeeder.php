<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@aquareport.com',
            'password' => Hash::make('11111111'),
            'is_admin' => true,
        ]);

        // Regular users
        User::create([
            'name' => 'User One',
            'email' => 'user1@aquareport.com',
            'password' => Hash::make('11111111'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'User Two',
            'email' => 'user2@aquareport.com',
            'password' => Hash::make('11111111'),
            'is_admin' => false,
        ]);
    }
}
