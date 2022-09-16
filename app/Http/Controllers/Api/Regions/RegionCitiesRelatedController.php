<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityCollection;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionCitiesRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (new CityCollection(Region::findOrFail($id)->cities))->response();
    }
}
