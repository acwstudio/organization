<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityRelationshipsRepository;

final class CitiesRegionStoreRelationshipsPipe
{
    protected CityRelationshipsRepository $cityRelationsRepository;

    /**
     * @param CityRelationshipsRepository $cityRelationsRepository
     */
    public function __construct(CityRelationshipsRepository $cityRelationsRepository)
    {
        $this->cityRelationsRepository = $cityRelationsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     * @throws \ReflectionException
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $relationData = data_get($data, 'data.relationships.region');

        if ($relationData) {
            data_set($data, 'relation_data', $relationData);
            data_set($data, 'relation_method', 'region');

            $this->cityRelationsRepository->updateRelations($data);
        }

        return $next($data);
    }
}
