<?php

namespace App\Http\Controllers\Robots;

use App\Actions\GetRobotsLatestEventAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRobotsLatestEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(GetRobotsLatestEventAction::run());
    }
}
