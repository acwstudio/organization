<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictResource;
use App\Services\Api\Regions\RegionsFederalDistrictRelationsService;
use Illuminate\Http\JsonResponse;

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
        data_set($data, 'relation_method', 'federalDistrict');
        data_set($data, 'id', $id);

        $federalDistrict = $this->regionsFederalDistrictRelationsService->indexRelations($data)->first();

        return $federalDistrict ?
            (new FederalDistrictResource($federalDistrict))->response() : response()->json(null, 204);
    }
}
