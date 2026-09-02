<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Robot;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = now()->timestamp;
        $currentTime = $time - 1000;
        $robots = Robot::all();
        $events = [];
        $statusList = ['active', 'maintenance', 'idle'];
        while ($currentTime < $time + 1000) {
            foreach($robots as $robot) {
                $events[] = [
                    'id' => (string)Str::uuid(),
                    'time' => $currentTime,
                    'x' => 0,
                    'y' => 0,
                    'status' => array_rand($statusList),
                    'battery' => 100.00,
                    'robot_id' => $robot->id
                ];
            }
            $currentTime +=5;
        }
        Event::factory()->createMany($events);
    }
}
