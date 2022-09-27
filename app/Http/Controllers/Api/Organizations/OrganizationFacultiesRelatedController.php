<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Faculties\FacultyCollection;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationFacultiesRelatedController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        $faculty = Organization::findOrFail($id)->faculties;

        return $faculty ? (new FacultyCollection($faculty))->response() : response()->json(null, 204);
    }
}
