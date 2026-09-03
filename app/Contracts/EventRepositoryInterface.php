<?php

namespace App\Contracts;

use App\Data\CreateMockEventsData;



interface EventRepositoryInterface
{
    public function createMockEvents(CreateMockEventsData $data): void;
}