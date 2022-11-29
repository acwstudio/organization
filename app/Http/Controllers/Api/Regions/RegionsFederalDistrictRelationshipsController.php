<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Regions\RegionsFederalDistrictUpdateRelationshipsRequest;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictIdentifierResource;
use App\Services\Api\Regions\RegionsFederalDistrictRelationsService;
use Illuminate\Http\JsonResponse;

class RegionsFederalDistrictRelationshipsController extends Controller
{
    protected RegionsFederalDistrictRelationsService $regionsFederalDistrictRelationsService;

    public function __construct(RegionsFederalDistrictRelationsService $regionsFederalDistrictRelationsService)
    {
        $this->regionsFederalDistrictRelationsService = $regionsFederalDistrictRelationsService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        data_set($data, 'relation_method', 'federalDistrict');
        data_set($data, 'id', $id);

        $federalDistrict = $this->regionsFederalDistrictRelationsService->indexRelations($data)->first();

        return $federalDistrict ?
            (new FederalDistrictIdentifierResource($federalDistrict))->response() : response()->json(null, 204);
    }

    /**
     * @param RegionsFederalDistrictUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function update(RegionsFederalDistrictUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        data_set($data, 'relation_data', $request->all());
        data_set($data, 'relation_method', 'federalDistrict');
        data_set($data, 'id', $id);

        $this->regionsFederalDistrictRelationsService->updateRelations($data);

        return response()->json(null, 204);
    }
}
