<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionCitiesRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (CityIdentifierResource::collection(Region::findOrFail($id)->cities))->response();
    }

    public function update(int $id)
    {

    }
}
