<?php

namespace App\Http\Controllers\Events;

use App\Actions\GetRobotsActiveTrendAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRobotsActiveTrendController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(GetRobotsActiveTrendAction::run());
    }
}
