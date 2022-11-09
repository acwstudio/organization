<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityOrganizationsRelationsRepository;

final class CityOrganizationsUpdateRelationshipsPipe
{
    protected CityOrganizationsRelationsRepository $cityOrganizationsRelaionsRepository;

    /**
     * @param CityOrganizationsRelationsRepository $cityOrganizationsRelaionsRepository
     */
    public function __construct(CityOrganizationsRelationsRepository $cityOrganizationsRelaionsRepository)
    {
        $this->cityOrganizationsRelaionsRepository = $cityOrganizationsRelaionsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next)
    {
        $relationshipsData = data_get($data, 'data.relationships.organizations');
        data_set($relationshipsData, 'city_id', data_get($data, 'city_id'));

        $this->cityOrganizationsRelaionsRepository->updateToManyRelationships($relationshipsData);


        return $next($data);
    }
}
