<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\Region;
use App\Pipelines\Regions\RegionPipeline;
use App\Repositories\Api\Regions\RegionRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class RegionService
{
    protected RegionRepository $regionRepository;
    protected RegionPipeline $regionPipeline;

    /**
     * @param RegionRepository $regionRepository
     * @param RegionPipeline $regionPipeline
     */
    public function __construct(RegionRepository $regionRepository, RegionPipeline $regionPipeline)
    {
        $this->regionRepository= $regionRepository;
        $this->regionPipeline = $regionPipeline;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->regionRepository->index();
    }

    /**
     * @param array $data
     * @return Model|Region
     * @throws \Exception
     */
    public function store(array $data): Model | Region
    {
        return $this->regionPipeline->store($data);
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        return $this->regionRepository->show($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    public function update(array $data, int $id): void
    {
        data_set($data, 'id', $id);

        $this->regionPipeline->update($data);
    }

    /**
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function destroy(int $id): void
    {
        data_set($data, 'id', $id);

        $this->regionPipeline->destroy($data);
    }
}
