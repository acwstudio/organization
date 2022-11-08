<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CitiesRegionRelationsRepository;

final class CitiesRegionStoreRelationshipsPipe
{
    protected CitiesRegionRelationsRepository $citiesRegionRelationsRepository;

    /**
     * @param CitiesRegionRelationsRepository $citiesRegionRelationsRepository
     */
    public function __construct(CitiesRegionRelationsRepository $citiesRegionRelationsRepository)
    {
        $this->citiesRegionRelationsRepository = $citiesRegionRelationsRepository;
    }

    public function handle(array $data, \Closure $next): mixed
    {
        $relationshipsData = data_get($data, 'data.relationships.region');

        if ($relationshipsData) {

            data_set($relationshipsData, 'city_id', data_get($data, 'city_id'));

            $this->citiesRegionRelationsRepository->updateToOneRelationship($relationshipsData);
        }

        return $next($data);
    }
}
