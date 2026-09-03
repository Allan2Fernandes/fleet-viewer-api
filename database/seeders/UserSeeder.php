<?php

namespace Database\Seeders;

use App\Data\RegisterUserData;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Specific known user (e.g., for local login/testing)
        $data = ['name' => 'Allan Fernandes', 'email' => 'allan2fernandes@hotmail.com','password' => '12345678'];
        User::create(array_merge($data, ['id' => (string) Str::uuid(), 'email_verified_at' => now()]));

        
    }
}