<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeIdentifierResource;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationTypesParentRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $parent = OrganizationType::find($id)->parent;

        return $parent ? (new OrganizationTypeIdentifierResource($parent))->response() : response()->json(null, 204);
    }

    public function update(int $id)
    {

    }
}
