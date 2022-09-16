<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsCityRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $city = Organization::findOrFail($id)->city;

        return $city ? (new CityIdentifierResource($city))->response() : response()->json(null, 204);
    }

    public function update(int $id)
    {

    }
}
