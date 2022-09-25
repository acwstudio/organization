<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationChildrenRelationshipsController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        return (OrganizationIdentifierResource::collection(Organization::findOrFail($id)->children))->response();
    }

    public function update(string $id)
    {

    }
}
