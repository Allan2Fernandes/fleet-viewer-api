<?php

namespace App\Http\Controllers\Events;

use App\Actions\CreateDataForExistingFleetAction;
use App\Http\Controllers\Controller;
use App\Jobs\GenerateMockData;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CreateDataForExistingFleetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        DB::beginTransaction();
        CreateDataForExistingFleetAction::run();
        DB::commit();
        return new JsonResponse(['message' => 'Created more mock data']);
    }
}
