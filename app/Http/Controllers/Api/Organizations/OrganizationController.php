<?php

namespace App\Http\Controllers\Api\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Organizations\OrganizationIndexRequest;
use App\Http\Requests\Api\V1\Organizations\OrganizationStoreRequest;
use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Http\Resources\Api\Organizations\OrganizationResource;
use App\Services\Api\Organizations\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    private OrganizationService $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(OrganizationIndexRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $organizations = $this->organizationService->index()->simplePaginate($perPage);

        return (new OrganizationCollection($organizations))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrganizationStoreRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(OrganizationStoreRequest $request)
    {
        $data = $request->all();

        $organization = $this->organizationService->store($data);

        return (new OrganizationResource($organization))
            ->response()
            ->header('Location', route('organizations.show', [
                'id' => $organization->id
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $organization = $this->organizationService->show($id)->first();

        return (new OrganizationResource($organization))->response();
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
