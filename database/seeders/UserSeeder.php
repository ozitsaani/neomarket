<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin NeoMarket',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Customer NeoMarket',
            'email' => 'customer@example.com',
            'password' => 'password',
            'role' => 'customer',
        ]);
    }
}