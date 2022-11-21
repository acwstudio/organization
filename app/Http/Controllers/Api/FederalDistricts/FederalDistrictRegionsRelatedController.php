<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Services\Api\FederalDistricts\FederalDistrictRegionsRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelatedController extends Controller
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
    public function index(Request $request, $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        $regions = $this->federalDistrictRegionsRelationService->indexRelations($id)->simplePaginate($perPage);

        return (new RegionCollection($regions))->response();
    }
}
