<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictRegionsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\FederalDistrictRepository;
use App\Services\Api\FederalDistrictService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelationshipsController extends Controller
{
    protected FederalDistrictService $federalDistrictService;

    /**
     * @param FederalDistrictService $federalDistrictService
     */
    public function __construct(FederalDistrictService $federalDistrictService)
    {
        $this->federalDistrictService = $federalDistrictService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $models = $this->federalDistrictService->indexIdentifiers('regions', $id)->paginate();

        return (RegionIdentifierResource::collection($models))->response();
    }

    /**
     * @param FederalDistrictRegionsUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(FederalDistrictRegionsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->federalDistrictService->saveRelationships($request->all(), $id);

        return response()->json(null, 204);
    }
}
