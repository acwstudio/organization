<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cities\CityCollection;
use App\Models\City;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsCityRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $city = Organization::findOrFail($id)->city;

        return $city ? (new CityCollection($city))->response() : response()->json(null, 204);
    }
}
