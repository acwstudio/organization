<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Services\Api\Organizations\OrganizationChildrenRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationChildrenRelatedController extends Controller
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

        data_set($data, 'relation_method', 'children');
        data_set($data, 'id', $id);

        $children = $this->organizationChildrenRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (new OrganizationCollection($children))->response();
    }
}
