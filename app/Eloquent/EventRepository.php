<?php

namespace App\Eloquent;

use App\Contracts\EventRepositoryInterface;
use App\Data\CreateMockEventsData;
use App\Models\Event;
use App\Models\Robot;
use Database\Seeders\EventSeeder;
use Illuminate\Support\Collection;
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

}