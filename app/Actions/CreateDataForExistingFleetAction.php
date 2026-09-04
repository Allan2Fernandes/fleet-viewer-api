<?php

namespace App\Actions;

use App\Contracts\EventRepositoryInterface;
use App\Jobs\GenerateMockData;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateDataForExistingFleetAction
{
    use AsAction;

    private EventRepositoryInterface $eventRepositoryInterface;

    public function __construct(EventRepositoryInterface $eventRepositoryInterface) {
        $this->eventRepositoryInterface = $eventRepositoryInterface;
    }
    

    public function handle()
    {
        $this->eventRepositoryInterface->generateMoreMockEvents();    
    }
}
