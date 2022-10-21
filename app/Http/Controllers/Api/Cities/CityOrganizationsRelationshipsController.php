<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cities\CityOrganizationsUpdateRelationshipsRequest;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Models\City;
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
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $organizations = $this->cityOrganizationsRelationsService->indexRelations($id)->paginate();

        return (OrganizationIdentifierResource::collection($organizations))->response();
    }

    /**
     * @param CityOrganizationsUpdateRelationshipsRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CityOrganizationsUpdateRelationshipsRequest $request, int $id): JsonResponse
    {
        $this->cityOrganizationsRelationsService->updateRelations($request->all(), $id);

        return response()->json(null, 204);
    }
}
