<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityCollection;
use App\Services\Api\Regions\RegionCitiesRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionCitiesRelatedController extends Controller
{
    protected RegionCitiesRelationsService $regionCitiesRelationsService;

    /**
     * @param RegionCitiesRelationsService $regionCitiesRelationsService
     */
    public function __construct(RegionCitiesRelationsService $regionCitiesRelationsService)
    {
        $this->regionCitiesRelationsService = $regionCitiesRelationsService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(Request $request, int $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        data_set($data, 'relation_method', 'cities');
        data_set($data, 'id', $id);

        $cities = $this->regionCitiesRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (new CityCollection($cities))->response();
    }
}
