<?php

namespace App\Http\Controllers;

use App\Actions\GetListOfRobotsAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetListOfRobotsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(GetListOfRobotsAction::run());
    }
}
