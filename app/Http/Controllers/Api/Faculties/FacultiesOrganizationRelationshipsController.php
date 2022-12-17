<?php

namespace App\Http\Controllers\Api\Faculties;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ApiEntityIdentifierResource;
use App\Models\Faculty;
use Illuminate\Http\JsonResponse;

class FacultiesOrganizationRelationshipsController extends Controller
{
    public function index(int $id): JsonResponse
    {
        $organization = Faculty::findOrFail($id)->organization;

        return $organization ?
            (new ApiEntityIdentifierResource($organization))->response() : response()->json(null, 204);
    }

    public function update(int $id)
    {

    }
}
