<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityOrganizationsRelatedController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        return (new OrganizationCollection(City::findOrFail($id)->organizations))->response();
    }
}
