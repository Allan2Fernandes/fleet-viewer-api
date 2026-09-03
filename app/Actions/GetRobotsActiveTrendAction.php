<?php

namespace App\Actions;

use App\Contracts\EventRepositoryInterface;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRobotsActiveTrendAction
{
    use AsAction;

    private EventRepositoryInterface $eventRepositoryInterface;

    public function __construct(EventRepositoryInterface $eventRepositoryInterface) {
        $this->eventRepositoryInterface = $eventRepositoryInterface;
    }
    

    public function handle(): Collection
    {
        return $this->eventRepositoryInterface->getRobotsActiveTrend();
    }
}
