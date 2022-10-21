<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Regions\RegionCitiesUpdateRelationshipsRequest;
use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Services\Api\Regions\RegionCitiesRelationsService;
use Illuminate\Http\JsonResponse;

class RegionCitiesRelationshipsController extends Controller
{
    protected RegionCitiesRelationsService $regionCitiesRelationsService;

    /**
     * @param RegionCitiesRelationsService $regionCitiesRelationsService
     */
    public function __construct(RegionCitiesRelationsService $regionCitiesRelationsService)
    {
        $this->regionCitiesRelationsService = $regionCitiesRelationsService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $cities = $this->regionCitiesRelationsService->indexRelations($id)->paginate();

        return (CityIdentifierResource::collection($cities))->response();
    }

    /**
     * @param RegionCitiesUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(RegionCitiesUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->regionCitiesRelationsService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
