<?php

namespace App\Contracts;

use App\Data\GetRobotsLatestEventData;
use Illuminate\Support\Collection;

interface RobotRepositoryInterface
{
    public function getRobotsLatestEvents(GetRobotsLatestEventData $data): Collection;

    public function getListOfRobots(): Collection;
}