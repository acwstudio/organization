<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityCollection;
use App\Models\Region;
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
    public function index(int $id): JsonResponse
    {
        $models = $this->regionCitiesRelationsService->indexRelations($id)->paginate();

        return (new CityCollection($models))->response();
    }
}
