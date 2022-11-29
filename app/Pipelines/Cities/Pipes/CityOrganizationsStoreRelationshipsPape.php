<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityRelationsRepository;

final class CityOrganizationsStoreRelationshipsPape
{
    protected CityRelationsRepository $cityRelaionsRepository;

    /**
     * @param CityRelationsRepository $cityRelaionsRepository
     */
    public function __construct(CityRelationsRepository $cityRelaionsRepository)
    {
        $this->cityRelaionsRepository = $cityRelaionsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     * @throws \ReflectionException
     */
    public function handle(array $data, \Closure $next)
    {
        $relationData = data_get($data, 'data.relationships.organizations');

        if ($relationData) {
            data_set($data, 'relation_data', $relationData);
            data_set($data, 'relation_method', 'organizations');

            $this->cityRelaionsRepository->updateRelations($data);
        }

        return $next($data);
    }
}
