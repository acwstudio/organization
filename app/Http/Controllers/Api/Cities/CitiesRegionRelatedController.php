<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionResource;
use App\Models\City;
use App\Services\Api\Cities\CitiesRegionRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $region = $this->citiesRegionRelationsService->indexRelations($id);

        return $region ? (new RegionResource($region))->response() : response()->json(null, 204);
    }
}
