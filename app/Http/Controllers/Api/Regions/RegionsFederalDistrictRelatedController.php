<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionsFederalDistrictRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $federalDistrict = Region::findOrFail($id)->federalDistrict;

        return $federalDistrict ?
            (new FederalDistrictResource($federalDistrict))->response() : response()->json(null, 204);
    }
}
