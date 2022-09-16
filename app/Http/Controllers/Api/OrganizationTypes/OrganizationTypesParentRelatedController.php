<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeIdentifierResource;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeResource;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationTypesParentRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $parent = OrganizationType::findOrFail($id)->parent;

        return $parent ? (new OrganizationTypeResource($parent))->response() : response()->json(null, 204);
    }
}
