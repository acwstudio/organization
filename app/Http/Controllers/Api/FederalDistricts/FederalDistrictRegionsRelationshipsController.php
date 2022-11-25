<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictRegionsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Services\Api\FederalDistricts\FederalDistrictRegionsRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelationshipsController extends Controller
{
    protected FederalDistrictRegionsRelationsService $federalDistrictRegionsRelationService;

    /**
     * @param FederalDistrictRegionsRelationsService $federalDistrictRegionsRelationService
     */
    public function __construct(FederalDistrictRegionsRelationsService $federalDistrictRegionsRelationService)
    {
        $this->federalDistrictRegionsRelationService = $federalDistrictRegionsRelationService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function index(Request $request, int $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        data_set($data, 'relation', 'regions');
        data_set($data, 'id', $id);

        $regions = $this->federalDistrictRegionsRelationService->indexRelation($data)->simplePaginate($perPage);

        return (RegionIdentifierResource::collection($regions))->response();
    }

    /**
     * @param FederalDistrictRegionsUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(FederalDistrictRegionsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        data_set($data, 'request', $request->all());
        data_set($data, 'relation', 'regions');
        data_set($data, 'id', $id);

        $this->federalDistrictRegionsRelationService->updateRelations($data);

        return response()->json(null, 204);
    }

    public function store(FederalDistrictRegionsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        data_set($data, 'relation_data', $request->all());
        data_set($data, 'relation_method', 'regions');
        data_set($data, 'id', $id);

        $this->federalDistrictRegionsRelationService->storeRelations($data);

        return response()->json(null, 204);
    }
}
