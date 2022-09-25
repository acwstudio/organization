<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsParentRelationshipsController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        $parent = Organization::findOrFail($id)->parent;

        return $parent ? (new OrganizationIdentifierResource($parent))->response() : response()->json(null, 204);
    }

    public function update(string $id)
    {

    }
}
