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
        $ids = data_get($data, 'data.relationships.cities.data.*.id');

        if ($ids) {
            $id = data_get($data, 'id');
            $this->regionCitiesRelationsRepository->updateRelations($ids, $id);
        }

        return $next($data);
    }
}
