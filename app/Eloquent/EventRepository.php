<?php

namespace App\Eloquent;

use App\Contracts\EventRepositoryInterface;
use App\Data\CreateMockEventsData;
use App\Models\Event;
use App\Models\Robot;
use Database\Seeders\EventSeeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Log;



class EventRepository implements EventRepositoryInterface
{
    public function createMockEvents(CreateMockEventsData $data): void {

        Event::query()
            ->select('id')
            ->chunkById(1000, function ($events) {
                Event::query()
                    ->whereIn('id', $events->pluck('id'))
                    ->delete();
                });


        Robot::query()
            ->select('id')
            ->chunkById(100, function ($events) {
                Robot::query()
                    ->whereIn('id', $events->pluck('id'))
                    ->delete();
                });


        $types = ['Picker', 'Hauler'];
        $robots = [];
        for ($i=0; $i < $data->fleet_size; $i++) { 
            
            $robots[] = [
                'id' => 'r' . $i,
                'type' => $types[array_rand($types)],
            ];
        }

        foreach (array_chunk($robots, 100) as $chunk) {
            Robot::factory()->createMany($chunk);
        }
        app(EventSeeder::class)->run();
    }

    public function getRobotsActiveTrend(): Collection {
        $robots = Robot::with([
            'events' => function ($query) {
                $query->select([
                    'id',
                    'time',
                    'robot_id',
                    'status',
                ])
                ->where('time', '<=', now()->timestamp)
                ->orderByDesc('time')
                ->limit(1);
            }
        ])
        ->select([
            'id',
            'type',
        ])
        ->get();

        $totalRobots = $robots->count();
        $activeRobotCount = $robots->filter(fn ($robot) => $robot->events->first()?->status === 'active')->count();
        $maintenanceRobotCount = $robots->filter(fn ($robot) => $robot->events->first()?->status === 'maintenance')->count();
        $idleRobotCount = $robots->filter(fn ($robot) => $robot->events->first()?->status === 'idle')->count();

         return collect([
            'total_count' => $totalRobots,
            'active_count' => $activeRobotCount,
            'maintenance_count' => $maintenanceRobotCount,
            'idle_count' => $idleRobotCount
         ]);
    }

    public function generateMoreMockEvents(): void
    {
        $event = Event::query()
            ->select(['id', 'time'])
            ->orderByDesc('time')
            ->first();
        $startTime =  $event->time;

        $interval = (int) env('MOCK_EVENT_INTERVAL', 400);
        $currentTime = $startTime;
        $robots = Robot::all();
        $events = [];
        $statusList = ['active', 'active', 'active', 'maintenance', 'idle'];
        $previousRobotPositionsMap = [];
        $previousBatteryMap = [];

        foreach ($robots as $robot) {
            $x = rand(0, 900);
            $y = rand(0, 560);
            $battery = $robot->battery - rand(1,100)/100;
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

        while ($currentTime < $startTime + $interval) {
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

        foreach (array_chunk($events, 1000) as $chunk) {
            Event::factory()->createMany($chunk);
        }
    }

}