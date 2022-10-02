<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Models\FederalDistrict;
use App\Services\Api\FederalDistrictService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelatedController extends Controller
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

        return (new RegionCollection($models))->response();
    }
}
