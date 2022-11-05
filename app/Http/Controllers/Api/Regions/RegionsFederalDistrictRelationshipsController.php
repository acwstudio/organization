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
        $federalDistrict = $this->regionsFederalDistrictRelationsService->indexRelations($id);

        return (new FederalDistrictIdentifierResource($federalDistrict))->response();
    }

    /**
     * @param RegionsFederalDistrictUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(RegionsFederalDistrictUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->regionsFederalDistrictRelationsService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
