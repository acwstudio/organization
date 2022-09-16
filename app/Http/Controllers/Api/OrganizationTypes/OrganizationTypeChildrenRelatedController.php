<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeCollection;
use App\Models\OrganizationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationTypeChildrenRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (new OrganizationTypeCollection(OrganizationType::findOrFail($id)->children))->response();
    }
}
