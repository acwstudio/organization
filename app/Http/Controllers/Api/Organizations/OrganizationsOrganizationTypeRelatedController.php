<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsOrganizationTypeRelatedController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        $organizationType = Organization::findOrFail($id)->organizationType;

        return $organizationType ?
            (new OrganizationTypeResource($organizationType))->response() : response()->json(null, 204);
    }
}
