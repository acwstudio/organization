<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictIdentifierResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionsFederalDistrictRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $federalDistrict = Region::findOrFail($id)->federalDistrict;

        return $federalDistrict ?
            (new FederalDistrictIdentifierResource($federalDistrict))->response() : response()->json(null, 204);
    }

    public function update(int $id)
    {

    }
}
