<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityOrganizationsRelationsRepository;

final class CityOrganizationsStoreRelationPipe
{
    protected CityOrganizationsRelationsRepository $cityOrganizationsRelaionsRepository;

    /**
     * @param CityOrganizationsRelationsRepository $cityOrganizationsRelaionsRepository
     */
    public function __construct(CityOrganizationsRelationsRepository $cityOrganizationsRelaionsRepository)
    {
        $this->cityOrganizationsRelaionsRepository = $cityOrganizationsRelaionsRepository;
    }

    public function handle(array $data, \Closure $next)
    {
        // to do something

        return $next($data);
    }
}
