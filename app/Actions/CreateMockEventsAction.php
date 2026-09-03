<?php

namespace App\Actions;

use App\Contracts\EventRepositoryInterface;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateMockEventsAction
{
    use AsAction;

    public EventRepositoryInterface $eventRepositoryInterface;

    public function __construct(EventRepositoryInterface $eventRepositoryInterface) {
        $this->eventRepositoryInterface = $eventRepositoryInterface;
    }
    

    public function handle()
    {
        $this->eventRepositoryInterface->createMockEvents();
    }
}
