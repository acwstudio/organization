<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Regions\RegionCitiesUpdateRelationshipsRequest;
use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Models\City;
use App\Models\Region;
use App\Services\Api\Regions\RegionCitiesRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $models = $this->regionCitiesRelationsService->indexRelations($id)->paginate();

        return (CityIdentifierResource::collection($models))->response();
    }

    public function update(RegionCitiesUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->regionCitiesRelationsService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
