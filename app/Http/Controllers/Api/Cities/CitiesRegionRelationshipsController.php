<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cities\CitiesRegionUpdateRelationshipsRequest;
use App\Http\Requests\Api\V1\Cities\CityOrganizationsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Models\City;
use App\Services\Api\Cities\CitiesRegionRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitiesRegionRelationshipsController extends Controller
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
        $region = City::findOrFail($id)->region;

        return $region ? (new RegionIdentifierResource($region))->response() : response()->json();
    }

    /**
     * @param CitiesRegionUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CitiesRegionUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->citiesRegionRelationsService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
