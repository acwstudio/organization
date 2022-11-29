<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionResource;
use App\Services\Api\Cities\CitiesRegionRelationsService;
use Illuminate\Http\JsonResponse;

class CitiesRegionRelatedController extends Controller
{
    protected CitiesRegionRelationsService $citiesRegionRelationsService;

    /**
     * @param CitiesRegionRelationsService $citiesRegionRelationsService
     */
    public function __construct(CitiesRegionRelationsService $citiesRegionRelationsService)
    {
        $this->citiesRegionRelationsService = $citiesRegionRelationsService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        data_set($data, 'relation_method', 'region');
        data_set($data, 'id', $id);

        $region = $this->citiesRegionRelationsService->indexRelations($data)->first();

        return $region ? (new RegionResource($region))->response() : response()->json(null, 204);
    }
}
