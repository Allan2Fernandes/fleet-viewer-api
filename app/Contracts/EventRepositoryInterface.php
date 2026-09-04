<?php

namespace App\Contracts;

use App\Data\CreateMockEventsData;
use Illuminate\Support\Collection;



interface EventRepositoryInterface
{
    public function createMockEvents(CreateMockEventsData $data): void;

    public function getRobotsActiveTrend(): Collection;

    public function generateMoreMockEvents(): void;
}