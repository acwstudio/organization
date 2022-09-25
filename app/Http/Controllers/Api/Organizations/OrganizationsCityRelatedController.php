<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsCityRelatedController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        $city = Organization::findOrFail($id)->city;

        return $city ? (new CityResource($city))->response() : response()->json(null, 204);
    }
}
