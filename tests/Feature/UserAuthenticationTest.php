<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;
use Tests\TestCase;



class UserAuthenticationTest extends TestCase
{
      use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login_user_not_found(): void {

        $response = $this->post('api/auth/login', ['email' => 'allan@mail.com', 'password' => 'Some Password']);
 
        $response->assertStatus(401);
    }

    public function test_login_user_found(): void {
        $user = User::factory()->create([
            'id' => (string)Str::uuid(),
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);

        $response = $this->post('api/auth/login', [
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_incorrect_password(): void {
        $user = User::factory()->create([
            'id' => (string)Str::uuid(),
            'email' => 'allan@mail.com',
            'password' => 'Some Passwor',
        ]);

        $response = $this->post('api/auth/login', [
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);

        $response->assertStatus(401);
    }

    public function test_logout_success() {
        $user = User::factory()->create([
            'id' => (string)Str::uuid(),
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);


        $login_response = $this->post('api/auth/login', [
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);
        $token = $login_response->json()['token'];

        $logout_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('api/auth/logout');

        $logout_response->assertStatus(200);
    }

    public function test_missing_bearer_token() {
         $user = User::factory()->create([
            'id' => (string)Str::uuid(),
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);


        $login_response = $this->post('api/auth/login', [
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);
        $token = $login_response->json()['token'];

        $logout_response = $this->post('api/auth/logout');

        $logout_response->assertStatus(500);
    }
}