<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cities\CitiesRegionUpdateRelationshipsRequest;
use App\Http\Resources\Api\ApiEntityIdentifierResource;
use App\Services\Api\Cities\CitiesRegionRelationsService;
use Illuminate\Http\JsonResponse;

class CitiesRegionRelationshipsController extends Controller
{
    protected CitiesRegionRelationsService $citiesRegionRelationsService;

    /**
     * @param CitiesRegionRelationsService $citiesRegionRelationsService
     */
    public function __construct(CitiesRegionRelationsService $citiesRegionRelationsService)
    {
        $this->citiesRegionRelationsService = $citiesRegionRelationsService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        data_set($data, 'relation_method', 'region');
        data_set($data, 'id', $id);

        $model = $this->citiesRegionRelationsService->indexRelations($data)->first();

        return (new ApiEntityIdentifierResource($model))->response();
    }

    /**
     * @param CitiesRegionUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function update(CitiesRegionUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        data_set($data, 'relation_data', $request->all());
        data_set($data, 'relation_method', 'region');
        data_set($data, 'id', $id);

        $this->citiesRegionRelationsService->updateRelations($data);

        return response()->json(null, 204);
    }
}
