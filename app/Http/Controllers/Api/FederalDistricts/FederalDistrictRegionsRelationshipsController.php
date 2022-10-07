<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictRegionsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;
use App\Services\Api\FederalDistricts\FederalDistrictRegionsRelationService;
use App\Services\Api\FederalDistricts\FederalDistrictService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelationshipsController extends Controller
{
    protected FederalDistrictRegionsRelationService $federalDistrictRegionsRelationService;

    /**
     * @param FederalDistrictRegionsRelationService $federalDistrictRegionsRelationService
     */
    public function __construct(FederalDistrictRegionsRelationService $federalDistrictRegionsRelationService)
    {
        $this->federalDistrictRegionsRelationService = $federalDistrictRegionsRelationService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $models = $this->federalDistrictRegionsRelationService->indexRelations($id)->paginate();

        return (RegionIdentifierResource::collection($models))->response();
    }

    /**
     * @param FederalDistrictRegionsUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(FederalDistrictRegionsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->federalDistrictRegionsRelationService->saveRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
