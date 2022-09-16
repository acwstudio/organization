<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationTypeOrganizationsRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (OrganizationIdentifierResource::collection(OrganizationType::findOrFail($id)->organizations))->response();
    }

    public function update(int $id)
    {

    }
}
