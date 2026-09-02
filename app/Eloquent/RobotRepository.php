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
                $query->where('time', '<=', now()->timestamp)
                    ->orderByDesc('time')
                    ->limit(1);
            }
        ])->get();
    }
}