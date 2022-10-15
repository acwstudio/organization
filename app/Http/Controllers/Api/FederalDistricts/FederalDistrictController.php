<?php

namespace App\Http\Controllers\Api\FederalDistricts;

use App\Http\Controllers\Controller;
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
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page');

        $federalDistricts = $this->federalDistrictService->index()->paginate($perPage);

        return (new FederalDistrictCollection($federalDistricts))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FederalDistrictStoreRequest $request
     * @return JsonResponse
     */
    public function store(FederalDistrictStoreRequest $request): JsonResponse
    {
        $model = $this->federalDistrictService->store($request->all());

        return (new FederalDistrictResource($model))
            ->response()
            ->header('Location', route('federal-districts.show', [
                'id' => $model->id
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
     */
    public function update(FederalDistrictUpdateRequest $request, $id): JsonResponse
    {
        $this->federalDistrictService->update($request->all(), $id);

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $this->federalDistrictService->destroy($id);

        return response()->json(null, 204);
    }
}
