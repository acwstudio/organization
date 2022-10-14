<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityOrganizationsRelaionsRepository;

final class CitiesRegionUpdateRelationPipe
{
    protected CityOrganizationsRelaionsRepository $cityOrganizationsRelaionsRepository;

    /**
     * @param CityOrganizationsRelaionsRepository $cityOrganizationsRelaionsRepository
     */
    public function __construct(CityOrganizationsRelaionsRepository $cityOrganizationsRelaionsRepository)
    {
        $this->cityOrganizationsRelaionsRepository = $cityOrganizationsRelaionsRepository;
    }

    public function handle(array $data, \Closure $next)
    {
        // to do something

        return $next($data);
    }
}
