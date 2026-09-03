<?php

namespace App\Eloquent;

use App\Contracts\EventRepositoryInterface;
use App\Models\Event;
use Database\Seeders\EventSeeder;



class EventRepository implements EventRepositoryInterface
{
    public function createMockEvents(): void {
        Event::query()
            ->select('id')
            ->chunkById(1000, function ($events) {
                Event::query()
                    ->whereIn('id', $events->pluck('id'))
                    ->delete();
                });

        app(EventSeeder::class)->run();
    }
}