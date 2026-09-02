<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Robot;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Log;


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
        $previousRobotPositionsMap = [];
        foreach($robots as $robot) {
            $x = rand(0, 900);
            $y = rand(0, 560);
            $events[] = [
                'id' => (string)Str::uuid(),
                'time' => $currentTime,
                'x' => $x,
                'y' => $y,
                'status' => $statusList[array_rand($statusList)],
                'battery' => 100.00,
                'robot_id' => $robot->id
            ];

            $previousRobotPositionsMap[$robot->id] = ['x' => $x, 'y' => $y];
        }
        $currentTime += 5;
        
        while ($currentTime < $time + 1000) {
            foreach($robots as $robot) {
                $x = ($previousRobotPositionsMap[$robot->id]['x'] + rand(-25,25)) % 900;
                $y = ($previousRobotPositionsMap[$robot->id]['y'] + rand(-25,25)) % 560;
                $events[] = [
                    'id' => (string)Str::uuid(),
                    'time' => $currentTime,
                    'x' => $x,
                    'y' => $y,
                    'status' => $statusList[array_rand($statusList)],
                    'battery' => 100.00,
                    'robot_id' => $robot->id
                ];
                $previousRobotPositionsMap[$robot->id] = ['x' => $x, 'y' => $y];
            }
            $currentTime +=5;
        }
        Event::factory()->createMany($events);
    }
}
