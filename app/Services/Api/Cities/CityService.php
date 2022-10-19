<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Exceptions\PipelineException;
use App\Models\City;
use App\Pipelines\Cities\CityPipeline;
use App\Repositories\Api\Cities\CityRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class CityService
{
    /**
     * @var CityRepository
     */
    protected CityRepository $cityRepository;
    protected CityPipeline $cityPipeline;

    /**
     * @param \App\Repositories\Api\Cities\CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository, CityPipeline $cityPipeline)
    {
        $this->cityRepository = $cityRepository;
        $this->cityPipeline = $cityPipeline;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->cityRepository->index();
    }

    /**
     * @param array $data
     * @return Model|City
     * @throws PipelineException
     */
    public function store(array $data): Model | City
    {
        return $this->cityPipeline->store($data);
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        return $this->cityRepository->show($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    public function update(array $data, int $id): void
    {
        $model = City::findOrFail($id);

        data_set($data, 'model', $model);

        $this->cityPipeline->update($data);
    }

    /**
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    public function destroy(int $id): void
    {
        $model = City::findOrFail($id);

        data_set($data, 'model', $model);

        $this->cityPipeline->destroy($data);
    }
}
