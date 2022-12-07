<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationResource;
use App\Services\Api\Organizations\OrganizationsParentRelationsService;
use Illuminate\Http\JsonResponse;

class OrganizationsParentRelatedController extends Controller
{
    protected OrganizationsParentRelationsService $organizationsParentRelationsService;

    /**
     * @param OrganizationsParentRelationsService $organizationsParentRelationsService
     */
    public function __construct(OrganizationsParentRelationsService $organizationsParentRelationsService)
    {
        $this->organizationsParentRelationsService = $organizationsParentRelationsService;
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        data_set($data, 'relation_method', 'parent');
        data_set($data, 'id', $id);

        $organization = $this->organizationsParentRelationsService->indexRelations($data)->first();

        return $organization ? (new OrganizationResource($organization))->response() : response()->json(null, 204);
    }
}
