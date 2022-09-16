<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Models\FederalDistrict;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictRegionsRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (RegionIdentifierResource::collection(FederalDistrict::findOrFail($id)->regions))->response();
    }

    public function update(int $id)
    {

    }
}
