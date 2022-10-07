<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Pipelines\FederalDistricts\FederalDistrictPipeline;
use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class FederalDistrictService
{
    protected FederalDistrictRepository $federalDistrictRepository;
    protected FederalDistrictPipeline $federalDistrictPipeline;

    /**
     * @param FederalDistrictRepository $federalDistrictRepository
     * @param FederalDistrictPipeline $federalDistrictPipeline
     */
    public function __construct(
        FederalDistrictRepository $federalDistrictRepository, FederalDistrictPipeline $federalDistrictPipeline
    )
    {
        $this->federalDistrictRepository = $federalDistrictRepository;
        $this->federalDistrictPipeline = $federalDistrictPipeline;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->federalDistrictRepository->index();
    }

    /**
     * @param array $data
     * @return Model|FederalDistrict
     */
    public function store(array $data): Model|FederalDistrict
    {
        return $this->federalDistrictPipeline->store($data);
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        $item = FederalDistrict::findOrFail($id);

        return $this->federalDistrictRepository->show($item);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function update(array $data, int $id): void
    {
        $model = FederalDistrict::findOrFail($id);

        data_set($data, 'model', $model);

        $this->federalDistrictPipeline->update($data);
    }

    public function destroy(int $id)
    {
        $model = FederalDistrict::findOrFail($id);

        $this->federalDistrictPipeline->destroy($model);
    }
}
