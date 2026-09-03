<?php

namespace App\Http\Controllers\Robots;

use App\Actions\GetRobotsLatestEventAction;
use App\Data\GetRobotsLatestEventData;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetRobotsLatestEventRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRobotsLatestEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetRobotsLatestEventRequest $request): JsonResponse
    {
        $data = GetRobotsLatestEventData::from($request->validated());
        return new JsonResponse(GetRobotsLatestEventAction::run($data));
    }
}
