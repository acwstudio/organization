<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Regions\RegionCitiesUpdateRelationshipsRequest;
use App\Http\Resources\Api\Cities\CityIdentifierResource;
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
    public function index(Request $request, int $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        data_set($data, 'relation_method', 'cities');
        data_set($data, 'id', $id);

        $cities = $this->regionCitiesRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (CityIdentifierResource::collection($cities))->response();
    }

    /**
     * @param RegionCitiesUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(RegionCitiesUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        data_set($data, 'relation_data', $request->all());
        data_set($data, 'relation_method', 'cities');
        data_set($data, 'id', $id);

        $this->regionCitiesRelationsService->updateRelations($data);

        return response()->json(null, 204);
    }
}
