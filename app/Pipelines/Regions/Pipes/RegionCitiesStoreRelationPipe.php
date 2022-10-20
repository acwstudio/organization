<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;
use App\Repositories\Api\Regions\RegionRepository;

final class RegionCitiesStoreRelationPipe
{
    protected RegionCitiesRelationsRepository $regionCitiesRelationsRepository;

    /**
     * @param RegionRepository $regionRepository
     */
    public function __construct(RegionCitiesRelationsRepository $regionCitiesRelationsRepository)
    {
        $this->regionCitiesRelationsRepository = $regionCitiesRelationsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $relationshipsData = data_get($data, 'data.relationships.cities');

        data_set($relationshipsData, 'region_id', data_get($data, 'model')->id);

//        $this->regionCitiesRelationsRepository->anyFineMethod($relationshipsData);

        return $next($data);
    }
}
