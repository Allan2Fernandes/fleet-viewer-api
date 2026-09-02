<?php

namespace App\Eloquent;

use App\Contracts\RobotRepositoryInterface;
use App\Models\Robot;
use Illuminate\Support\Collection;

class RobotRepository implements RobotRepositoryInterface
{
    public function getRobotsLatestEvents(): Collection {
        return Robot::with([
            'events' => function ($query) {
                $query->select([
                    'id',
                    'time',
                    'robot_id',
                    'x',
                    'y',
                    'status',
                    'battery',
                ])
                ->where('time', '<=', now()->timestamp)
                ->orderByDesc('time')
                ->limit(1);
            }
        ])
        ->select([
            'id',
            'type',
        ])
        ->get();
    }

    public function getListOfRobots(): Collection {
        return Robot::query()->select(['id', 'type'])->get();
    }
}