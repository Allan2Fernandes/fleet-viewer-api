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
        $previousRobotPositionsMap = [];
        $previousBatteryMap = [];

        foreach ($robots as $robot) {
            $x = rand(0, 900);
            $y = rand(0, 560);
            $battery = 100 - rand(1,100)/100;
            $events[] = [
                'id' => (string) Str::uuid(),
                'time' => $currentTime,
                'x' => $x,
                'y' => $y,
                'status' => $statusList[array_rand($statusList)],
                'battery' => $battery,
                'robot_id' => $robot->id
            ];

            $previousRobotPositionsMap[$robot->id] = [
                'x' => $x,
                'y' => $y
            ];

            $previousBatteryMap[$robot->id] = $battery;
        }

        $currentTime += 5;

        while ($currentTime < $time + 1000) {
            foreach ($robots as $robot) {
                $previousX = $previousRobotPositionsMap[$robot->id]['x'];
                $previousY = $previousRobotPositionsMap[$robot->id]['y'];
                $battery = max(
                    0,
                    $previousBatteryMap[$robot->id] - rand(1, 100) / 500
                );

                $moveX = $battery > 0 ? rand(-25, 25) : 0;
                $moveY = $battery > 0 ? rand(-25, 25) : 0;

                $x = $previousX + $moveX;
                $y = $previousY + $moveY;

                // Bounce off left/right walls
                if ($x < 0) {
                    $x = -$x;
                } elseif ($x > 900) {
                    $x = 900 - ($x - 900);
                }

                // Bounce off top/bottom walls
                if ($y < 0) {
                    $y = -$y;
                } elseif ($y > 560) {
                    $y = 560 - ($y - 560);
                }

                $events[] = [
                    'id' => (string) Str::uuid(),
                    'time' => $currentTime,
                    'x' => $x,
                    'y' => $y,
                    'status' => $statusList[array_rand($statusList)],
                    'battery' => $battery,
                    'robot_id' => $robot->id
                ];

                $previousRobotPositionsMap[$robot->id] = [
                    'x' => $x,
                    'y' => $y
                ];

                $previousBatteryMap[$robot->id] = $battery;
            }

            $currentTime += 5;
        }

        Event::factory()->createMany($events);
    } 
}
