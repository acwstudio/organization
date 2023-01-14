<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Exceptions\PipelineException;
use App\Models\City;
use App\Pipelines\Cities\CityPipeline;
use App\Repositories\Api\Cities\CityRepository;
use App\Services\Api\AbstractCRUDService;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class CityService extends AbstractCRUDService
{
    /**
     * @var CityRepository
     */
    protected CityRepository $cityRepository;
    /**
     * @var CityPipeline
     */
    protected CityPipeline $cityPipeline;

    /**
     * @param CityRepository $cityRepository
     * @param CityPipeline $cityPipeline
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
     * @throws \Throwable
     */
    public function store(array $data): Model|City
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
     * @return void
     * @throws PipelineException
     * @throws \Throwable
     */
    public function update(array $data): void
    {
        $this->cityPipeline->update($data);
    }

    /**
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    public function destroy(int $id): void
    {
        $this->cityPipeline->destroy($id);
    }
}
