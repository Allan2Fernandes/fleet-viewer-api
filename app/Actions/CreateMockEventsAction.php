<?php

namespace App\Actions;

use App\Contracts\EventRepositoryInterface;
use App\Data\CreateMockEventsData;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateMockEventsAction
{
    use AsAction;

    public EventRepositoryInterface $eventRepositoryInterface;

    public function __construct(EventRepositoryInterface $eventRepositoryInterface) {
        $this->eventRepositoryInterface = $eventRepositoryInterface;
    }
    

    public function handle(CreateMockEventsData $data)
    {
        $this->eventRepositoryInterface->createMockEvents($data);
    }
}
