<?php

namespace App\Http\Controllers\Api\Cities;

use App\Exceptions\PipelineException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cities\CityStoreRequest;
use App\Http\Requests\Api\V1\Cities\CityUpdateRequest;
use App\Http\Resources\Api\Cities\CityCollection;
use App\Http\Resources\Api\Cities\CityResource;
use App\Services\Api\Cities\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @var CityService
     */
    private CityService $cityService;

    /**
     * @param \App\Services\Api\Cities\CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $cities = $this->cityService->index()->paginate($perPage);

        return (new CityCollection($cities))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityStoreRequest $request
     * @return JsonResponse
     * @throws PipelineException
     */
    public function store(CityStoreRequest $request): JsonResponse
    {
        $city = $this->cityService->store($request->all());

        return (new CityResource($city))
            ->response()
            ->header('Location', route('cities.show', [
                'id' => $city->id
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $city = $this->cityService->show($id)->first();

        return (new CityResource($city))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(CityUpdateRequest $request, $id)
    {
        $this->cityService->update($request->all(), $id);

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->cityService->destroy($id);

        return response()->json(null, 204);
    }
}
