<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ApiEntityIdentifierResource;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;

class OrganizationTypeChildrenRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (ApiEntityIdentifierResource::collection(OrganizationType::findOrFail($id)->children))->response();
    }

    public function update(int $id)
    {

    }
}
