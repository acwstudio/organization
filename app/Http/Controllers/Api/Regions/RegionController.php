<?php

namespace App\Http\Controllers\Api\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Regions\RegionStoreRequest;
use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Api\Regions\RegionResource;
use App\Services\Api\Regions\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * @var RegionService
     */
    private RegionService $regionService;

    /**
     * @param RegionService $regionService
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService =$regionService;
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

        $regions = $this->regionService->index()->paginate($perPage);

        return (new RegionCollection($regions))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegionStoreRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(RegionStoreRequest $request): JsonResponse
    {
        $model = $this->regionService->store($request->all());

        return (new RegionResource($model))
            ->response()
            ->header('Location', route('regions.show', [
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
        $region = $this->regionService->show($id)->first();

        return (new RegionResource($region))->response();
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
