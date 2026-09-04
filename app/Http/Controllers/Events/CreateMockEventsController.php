<?php

namespace App\Http\Controllers\Events;

use App\Actions\CreateMockEventsAction;
use App\Data\CreateMockEventsData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMockEventsRequest;
use DB;
use Illuminate\Http\JsonResponse;

class CreateMockEventsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateMockEventsRequest $request): JsonResponse
    {
        DB::beginTransaction(); 
        $data = CreateMockEventsData::from($request->validated());
        CreateMockEventsAction::run($data);
        DB::commit();
        return new JsonResponse(['message' => 'Mock data successfully generated']);
    }
}
