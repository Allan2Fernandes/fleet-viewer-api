<?php

namespace App\Http\Controllers;

use App\Actions\GetListOfRobotsAction;
use App\Http\Requests\GetListOfRobotsRequest;
use Illuminate\Http\JsonResponse;

class GetListOfRobotsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetListOfRobotsRequest $request): JsonResponse
    {
        return new JsonResponse(GetListOfRobotsAction::run());
    }
}
