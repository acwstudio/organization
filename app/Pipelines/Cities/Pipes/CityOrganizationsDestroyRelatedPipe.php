<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityOrganizationsRelaionsRepository;

final class CityOrganizationsDestroyRelatedPipe
{
    protected CityOrganizationsRelaionsRepository $cityOrganizationsRelaionsRepository;

    /**
     * @param CityOrganizationsRelaionsRepository $cityOrganizationsRelaionsRepository
     */
    public function __construct(CityOrganizationsRelaionsRepository $cityOrganizationsRelaionsRepository)
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
