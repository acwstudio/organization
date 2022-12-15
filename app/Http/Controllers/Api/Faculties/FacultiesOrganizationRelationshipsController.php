<?php

namespace App\Http\Controllers\Api\Faculties;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Models\Faculty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FacultiesOrganizationRelationshipsController extends Controller
{
    public function index(int $id): JsonResponse
    {
        $organization = Faculty::findOrFail($id)->organization;

        return $organization ?
            (new OrganizationIdentifierResource($organization))->response() : response()->json(null, 204);
    }

    public function update(int $id)
    {

    }
}
