<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Services\Api\Cities\CityOrganizationsRelationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityOrganizationsRelatedController extends Controller
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
    public function index(Request $request, int $id): JsonResponse
    {
        $perPage = $request->get('per_page');

        data_set($data, 'relation_method', 'organizations');
        data_set($data, 'id', $id);

        $organizations = $this->cityOrganizationsRelationsService->indexRelations($data)->simplePaginate($perPage);

        return (new OrganizationCollection($organizations))->response();
    }
}
