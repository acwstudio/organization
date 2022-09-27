<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Faculties\FacultyIdentifierResource;
use App\Models\Faculty;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationFacultiesRelationshipsController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        return (FacultyIdentifierResource::collection(Organization::findOrFail($id)->faculties))->response();
    }

    public function update(string $id)
    {

    }
}
