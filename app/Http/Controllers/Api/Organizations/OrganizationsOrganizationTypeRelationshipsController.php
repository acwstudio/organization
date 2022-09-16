<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeIdentifierResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsOrganizationTypeRelationshipsController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $organizationType = Organization::findOrFail($id)->organizationType;

        return $organizationType ?
            (new OrganizationTypeIdentifierResource($organizationType))->response() : response()->json(null, 204);
    }

    public function update(int $id)
    {

    }
}
