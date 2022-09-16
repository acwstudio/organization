<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeIdentifierResource;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationTypeChildrenRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (OrganizationTypeIdentifierResource::collection(OrganizationType::findOrFail($id)->children))->response();
    }

    public function update(int $id)
    {

    }
}
