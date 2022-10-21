<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityOrganizationsRelationsRepository;

final class CityOrganizationsDestroyRelatedPipe
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
    public function handle(array $data, \Closure $next): mixed
    {
        $model = data_get($data, 'model');

        $this->cityOrganizationsRelaionsRepository->destroyRelatedModels('organizations', $model);

        return $next($data);
    }
}
