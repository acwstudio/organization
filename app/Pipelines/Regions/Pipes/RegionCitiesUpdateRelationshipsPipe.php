<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRelationshipsRepository;

final class RegionCitiesUpdateRelationshipsPipe
{
    protected RegionRelationshipsRepository $regionRelationsRepository;

    /**
     * @param RegionRelationshipsRepository $regionRelationsRepository
     */
    public function __construct(RegionRelationshipsRepository $regionRelationsRepository)
    {
        $this->regionRelationsRepository = $regionRelationsRepository;
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

            $this->regionRelationsRepository->updateRelations($data);
        }

        return $next($data);
    }
}
