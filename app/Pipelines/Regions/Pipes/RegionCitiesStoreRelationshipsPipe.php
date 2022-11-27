<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRelationsRepository;

final class RegionCitiesStoreRelationshipsPipe
{
    protected RegionRelationsRepository $regionRelationRepository;

    /**
     * @param RegionRelationsRepository $regionRelationRepository
     */
    public function __construct(RegionRelationsRepository $regionRelationRepository)
    {
        $this->regionRelationRepository = $regionRelationRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     * @throws \ReflectionException
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $relationData = data_get($data, 'data.relationships.cities');

        if ($relationData) {
            data_set($data, 'relation_data', $relationData);
            data_set($data, 'relation_method', 'cities');

            $this->regionRelationRepository->updateRelations($data);
        }

        return $next($data);
    }
}
