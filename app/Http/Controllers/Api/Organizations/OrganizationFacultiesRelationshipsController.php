<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Faculties\FacultyIdentifierResource;
use App\Services\Api\Organizations\OrganizationChildrenRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationFacultiesRelationshipsController extends Controller
{
    protected OrganizationChildrenRelationsService $organizationChildrenRelationsService;

    /**
     * @param OrganizationChildrenRelationsService $organizationChildrenRelationsService
     */
    public function __construct(OrganizationChildrenRelationsService $organizationChildrenRelationsService)
    {
        $this->organizationChildrenRelationsService = $organizationChildrenRelationsService;
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

        $children = $this->organizationChildrenRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (FacultyIdentifierResource::collection($children))->response();
    }
}
