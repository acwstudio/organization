<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ApiEntityIdentifierResource;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;

class OrganizationTypesParentRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $parent = OrganizationType::findOrFail($id)->parent;

        return $parent ? (new ApiEntityIdentifierResource($parent))->response() : response()->json(null, 204);
    }
}
