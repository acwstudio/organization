<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Exceptions\PipelineException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FederalDistricts\FedefalDistrictIndexRequest;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictStoreRequest;
use App\Http\Requests\Api\V1\FederalDistricts\FederalDistrictUpdateRequest;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictCollection;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictResource;
use App\Services\Api\FederalDistricts\FederalDistrictService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederalDistrictController extends Controller
{
    /**
     * @var FederalDistrictService
     */
    private FederalDistrictService $federalDistrictService;

    /**
     * @param FederalDistrictService $federalDistrictService
     */
    public function __construct(FederalDistrictService $federalDistrictService)
    {
        $this->federalDistrictService = $federalDistrictService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(FedefalDistrictIndexRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $federalDistricts = $this->federalDistrictService->index()->simplePaginate($perPage)->appends($request->query());

        return (new FederalDistrictCollection($federalDistricts))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FederalDistrictStoreRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(FederalDistrictStoreRequest $request): JsonResponse
    {
        $data = $request->all();

        $federalDistrict = $this->federalDistrictService->store($data);

        return (new FederalDistrictResource($federalDistrict))
            ->response()
            ->header('Location', route('federal-districts.show', [
                'id' => $federalDistrict->id
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $federalDistrict = $this->federalDistrictService->show($id)->first();

        return (new FederalDistrictResource($federalDistrict))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FederalDistrictUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(FederalDistrictUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->all();
        data_set($data, 'id', $id);

        $this->federalDistrictService->update($data);

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws PipelineException
     * @throws \Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $this->federalDistrictService->destroy($id);

        return response()->json(null, 204);
    }
}
