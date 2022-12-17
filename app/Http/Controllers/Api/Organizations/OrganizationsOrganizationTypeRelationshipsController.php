<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ApiEntityIdentifierResource;
use App\Services\Api\Organizations\OrganizationsOrganizationTypeRelationsService;
use Illuminate\Http\JsonResponse;

class OrganizationsOrganizationTypeRelationshipsController extends Controller
{
    protected OrganizationsOrganizationTypeRelationsService $organizationsOrganizationTypeRelationsService;

    /**
     * @param OrganizationsOrganizationTypeRelationsService $organizationsOrganizationTypeRelationsService
     */
    public function __construct(OrganizationsOrganizationTypeRelationsService $organizationsOrganizationTypeRelationsService)
    {
        $this->organizationsOrganizationTypeRelationsService = $organizationsOrganizationTypeRelationsService;
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        data_set($data, 'relation_method', 'organizationType');
        data_set($data, 'id', $id);

        $organizationType = $this->organizationsOrganizationTypeRelationsService->indexRelations($data)->first();

        return $organizationType ?
            (new ApiEntityIdentifierResource($organizationType))->response() : response()->json(null, 204);
    }
}
