<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create the default developer user
        User::create([
            'name' => 'Developer',
            'email' => 'developer@example.com',
            'password' => Hash::make('Test@Password123#'), // Ensure password is hashed
        ]);
    }
}
