<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Models\FederalDistrict;
use App\Services\Api\FederalDistricts\FederalDistrictRegionsRelationService;
use App\Services\Api\FederalDistricts\FederalDistrictService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelatedController extends Controller
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

        return (new RegionCollection($models))->response();
    }
}
