<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Faculties\FacultyCollection;
use App\Services\Api\Organizations\OrganizationFacultiesRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationFacultiesRelatedController extends Controller
{
    protected OrganizationFacultiesRelationsService $organizationFacultiesRelationsService;

    /**
     * @param OrganizationFacultiesRelationsService $organizationFacultiesRelationsService
     */
    public function __construct(OrganizationFacultiesRelationsService $organizationFacultiesRelationsService)
    {
        $this->organizationFacultiesRelationsService = $organizationFacultiesRelationsService;
    }


    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function index(Request $request, string $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        data_set($data, 'relation_method', 'faculties');
        data_set($data, 'id', $id);

        $faculties = $this->organizationFacultiesRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (new FacultyCollection($faculties))->response();
    }
}
