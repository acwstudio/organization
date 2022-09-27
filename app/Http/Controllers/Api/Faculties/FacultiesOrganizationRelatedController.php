<?php

namespace App\Http\Controllers\Api\Faculties;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationResource;
use App\Models\Faculty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FacultiesOrganizationRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $organization = Faculty::findOrFail($id)->organization;

        return $organization ? (new OrganizationResource($organization))->response() : response()->json(null, 204);
    }
}
