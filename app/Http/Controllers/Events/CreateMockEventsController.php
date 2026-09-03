<?php

namespace App\Http\Controllers\Events;

use App\Actions\CreateMockEventsAction;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateMockEventsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        DB::beginTransaction();
        CreateMockEventsAction::run();
        DB::commit();
        return new JsonResponse(['message' => 'Mock data successfully generated']);
    }
}
