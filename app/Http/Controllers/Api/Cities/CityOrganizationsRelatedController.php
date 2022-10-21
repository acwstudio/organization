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
    public function index(int $id): JsonResponse
    {
        $organizations = $this->cityOrganizationsRelationsService->indexRelations($id)->paginate();

        return (new OrganizationCollection($organizations))->response();
    }
}
