<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Regions\RegionsFederalDistrictUpdateRelationshipsRequest;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictIdentifierResource;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictResource;
use App\Models\Region;
use App\Services\Api\Regions\RegionsFederalDistrictRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        return (new FederalDistrictResource($federalDistrict))->response();
    }

    public function update(RegionsFederalDistrictUpdateRelationshipsRequest $request, int $id)
    {
        $this->regionsFederalDistrictRelationsService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
