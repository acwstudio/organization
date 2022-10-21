<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CitiesRegionRelationsRepository;
use App\Repositories\Api\Cities\CityOrganizationsRelationsRepository;

final class CitiesRegionUpdateRelationPipe
{
    protected CitiesRegionRelationsRepository $citiesRegionRelationsRepository;

    /**
     * @param CitiesRegionRelationsRepository $citiesRegionRelationsRepository
     */
    public function __construct(CitiesRegionRelationsRepository $citiesRegionRelationsRepository)
    {
        $this->citiesRegionRelationsRepository = $citiesRegionRelationsRepository;
    }

    public function handle(array $data, \Closure $next)
    {
        $relationshipsData = data_get($data, 'data.relationships.region');
        data_set($relationshipsData, 'city_id', data_get($data, 'city_id'));

        $this->citiesRegionRelationsRepository->updateRelations($relationshipsData);

        return $next($data);
    }
}
