<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationChildrenRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        return (new OrganizationCollection(Organization::findOrFail($id)->children))->response();
    }
}
