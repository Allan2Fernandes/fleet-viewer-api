<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface RobotRepositoryInterface
{
    public function getRobotsLatestEvents(): Collection;
}