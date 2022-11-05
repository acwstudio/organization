<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictRegionsDestroyRelationshipsRequest;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictRegionsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;
use App\Services\Api\FederalDistricts\FederalDistrictRegionsRelationsService;
use App\Services\Api\FederalDistricts\FederalDistrictService;
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

        $regions = $this->federalDistrictRegionsRelationService->indexRelations($id)->paginate($perPage);

        return (RegionIdentifierResource::collection($regions))->response();
    }

    /**
     * @param FederalDistrictRegionsUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(FederalDistrictRegionsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->federalDistrictRegionsRelationService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
