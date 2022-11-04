<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;

final class RegionCitiesUpdateRelationshipsPipe
{
    protected RegionCitiesRelationsRepository $regionCitiesRelationsRepository;

    /**
     * @param RegionCitiesRelationsRepository $regionCitiesRelationsRepository
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

        if ($relationshipsData) {

            data_set($relationshipsData, 'region_id', data_get($data, 'region_id'));

            $this->regionCitiesRelationsRepository->updateToOneRelationship($relationshipsData);
        }

        return $next($data);
    }
}
