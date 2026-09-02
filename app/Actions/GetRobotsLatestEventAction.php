<?php

namespace App\Actions;

use App\Contracts\RobotRepositoryInterface;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRobotsLatestEventAction
{
    use AsAction;

    private RobotRepositoryInterface $robotRepositoryInterface;

    public function __construct(RobotRepositoryInterface $robotRepositoryInterface) {
        $this->robotRepositoryInterface = $robotRepositoryInterface;
    }
    

    public function handle(): Collection
    {
        return $this->robotRepositoryInterface->getRobotsLatestEvents();
    }
}
