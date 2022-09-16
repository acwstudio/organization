<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitiesRegionRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $region = City::findOrFail($id)->region;

        return $region ? (new RegionIdentifierResource($region))->response() : response()->json();
    }

    public function update(int $id)
    {

    }
}
