<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cities\CityOrganizationsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Services\Api\Cities\CityOrganizationsRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityOrganizationsRelationshipsController extends Controller
{
    protected CityOrganizationsRelationsService $cityOrganizationsRelationsService;

    /**
     * @param CityOrganizationsRelationsService $cityOrganizationsRelationsService
     */
    public function __construct(CityOrganizationsRelationsService $cityOrganizationsRelationsService)
    {
        $this->cityOrganizationsRelationsService = $cityOrganizationsRelationsService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function index(Request $request, int $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        data_set($data, 'relation_method', 'organizations');
        data_set($data, 'id', $id);

        $organizations = $this->cityOrganizationsRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (OrganizationIdentifierResource::collection($organizations))->response();
    }

    /**
     * @param CityOrganizationsUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function update(CityOrganizationsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        data_set($data, 'relation_data', $request->all());
        data_set($data, 'relation_method', 'organizations');
        data_set($data, 'id', $id);

        $this->cityOrganizationsRelationsService->updateRelations($data);

        return response()->json(null, 204);
    }
}
