<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityOrganizationsRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (OrganizationIdentifierResource::collection(City::findOrFail($id)->organizations))->response();
    }

    public function update(int $id)
    {

    }
}
