<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;
use App\Repositories\Api\Regions\RegionRepository;

final class RegionCitiesUpdateRelationPipe
{
    protected RegionCitiesRelationsRepository $regionCitiesRelationsRepository;

    /**
     * @param RegionCitiesRelationsRepository $regionCitiesRelationsRepository
     */
    public function __construct(RegionCitiesRelationsRepository $regionCitiesRelationsRepository)
    {
        $this->regionCitiesRelationsRepository = $regionCitiesRelationsRepository;
    }

    public function handle(array $data, \Closure $next)
    {
        $relationshipsData = data_get($data, 'data.relationships.cities');
        data_set($relationshipsData, 'region_id', data_get($data, 'region_id'));

        $this->regionCitiesRelationsRepository->updateRelations($relationshipsData);

        return $next($data);
    }
}
