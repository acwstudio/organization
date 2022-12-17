<?php

namespace App\Http\Controllers\Api\OrganizationTypes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrganizationTypes\OrganizationTypeIndexRequest;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeCollection;
use App\Services\Api\OrganizationTypes\OrganizationTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationTypeController extends Controller
{
    /**
     * @var OrganizationTypeService
     */
    private OrganizationTypeService $organizationTypeService;

    /**
     * @param OrganizationTypeService $organizationTypeService
     */
    public function __construct(OrganizationTypeService $organizationTypeService)
    {
        $this->organizationTypeService = $organizationTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(OrganizationTypeIndexRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $organizationTypes = $this->organizationTypeService->index()->simplePaginate($perPage)->appends($request->query());

        return (new OrganizationTypeCollection($organizationTypes))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
