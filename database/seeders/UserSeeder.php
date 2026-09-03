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
        $data = ['name' => 'Allan Fernandes', 'email' => 'allan2fernandes@hotmail.com','password' => env('SEEDER_USER1_PASSWORD')];
        User::create(array_merge($data, ['id' => (string) Str::uuid(), 'email_verified_at' => now()]));
        $data2 = ['name' => 'Peppermint user', 'email' => 'user2@peppermint.com','password' => env('SEEDER_USER2_PASSWORD')];
        User::create(array_merge($data2, ['id' => (string) Str::uuid(), 'email_verified_at' => now()]));
    }
}