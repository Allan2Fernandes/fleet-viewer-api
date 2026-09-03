<?php

namespace App\Eloquent;

use App\Contracts\EventRepositoryInterface;
use App\Data\CreateMockEventsData;
use App\Models\Event;
use App\Models\Robot;
use Database\Seeders\EventSeeder;



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
}