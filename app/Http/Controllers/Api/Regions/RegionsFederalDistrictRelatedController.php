<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictResource;
use App\Models\Region;
use App\Services\Api\Regions\RegionsFederalDistrictRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionsFederalDistrictRelatedController extends Controller
{
    protected RegionsFederalDistrictRelationsService $regionsFederalDistrictRelationsService;

    /**
     * @param RegionsFederalDistrictRelationsService $regionsFederalDistrictRelationsService
     */
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

        return $federalDistrict ?
            (new FederalDistrictResource($federalDistrict))->response() : response()->json(null, 204);
    }
}
