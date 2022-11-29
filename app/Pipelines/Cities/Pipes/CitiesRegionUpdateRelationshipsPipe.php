<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CitiesRegionRelationsRepository;
use App\Repositories\Api\Cities\CityRelationsRepository;

final class CitiesRegionUpdateRelationshipsPipe
{
    protected CityRelationsRepository $cityRelationsRepository;

    /**
     * @param CityRelationsRepository $cityRelationsRepository
     */
    public function __construct(CityRelationsRepository $cityRelationsRepository)
    {
        $this->cityRelationsRepository = $cityRelationsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     * @throws \ReflectionException
     */
    public function handle(array $data, \Closure $next)
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
