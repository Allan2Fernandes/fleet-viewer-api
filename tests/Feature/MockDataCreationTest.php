<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Robot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MockDataCreationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_creating_mock_data_no_fleet(): void
    {
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

        $create_mock_data_for_existing_fleet_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('api/events/create-mock-data');

        $this->assertEquals($create_mock_data_for_existing_fleet_response->json()['message'], 'Created more mock data');
    }

    public function test_creating_mock_data_existing_fleet(): void
    {
        $user = User::factory()->create([
            'id' => (string)Str::uuid(),
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);

        $types = ['Picker', 'Hauler'];
        $robots = [];
        for ($i=0; $i < 500; $i++) { 
            
            $robots[] = [
                'id' => 'r' . $i,
                'type' => $types[array_rand($types)],
            ];
        }

        Robot::factory()->createMany($robots);

        $login_response = $this->post('api/auth/login', [
            'email' => 'allan@mail.com',
            'password' => 'Some Password',
        ]);
        $token = $login_response->json()['token'];

        $create_mock_data_for_existing_fleet_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('api/events/create-mock-data');

        $this->assertEquals('Created more mock data', $create_mock_data_for_existing_fleet_response->json()['message']);
        $this->assertEquals(500, Robot::query()->count());
        $this->assertEquals(500*env('MOCK_EVENT_INTERVAL', 400)/5, Event::query()->count()); // 400 is the period, 5 is interval
    }

    public function test_create_data_fleet_and_events() {
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

        $create_mock_data_for_fleet_and_events_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('api/events/create-mock-events', ['fleet_size' => 500]);

        $this->assertEquals('Mock data successfully generated', $create_mock_data_for_fleet_and_events_response->json()['message']);
        $this->assertEquals(500, Robot::query()->count());
        $this->assertEquals(500*env('MOCK_EVENT_INTERVAL', 400)/5, Event::query()->count());
    }

    public function test_overlapping_DB_writes() {
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


        $create_mock_data_for_fleet_and_events_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('api/events/create-mock-events', ['fleet_size' => 500]);

        $create_mock_data_for_existing_fleet_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('api/events/create-mock-data');

        $this->assertEquals('Created more mock data', $create_mock_data_for_existing_fleet_response->json()['message']);
        $this->assertEquals('Mock data successfully generated', $create_mock_data_for_fleet_and_events_response->json()['message']);            
        $this->assertEquals(500, Robot::query()->count());

        // 500 robots, interval is 5, events generated twice, once from each api call
        $this->assertEquals(500*env('MOCK_EVENT_INTERVAL', 400)*2/5, Event::query()->count()); 
    }
}
