<?php

declare(strict_types=1);

namespace App\Pipelines\Organizations\Pipes;

use App\Repositories\Api\Organizations\OrganizationRepository;

final class OrganizationStorePipe
{
    protected OrganizationRepository $organizationRepository;

    /**
     * @param OrganizationRepository $regionRepository
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $model = $this->organizationRepository->store($data);

        data_set($data, 'model', $model);
        data_set($data, 'id', $model->id);

        return $next($data);
    }
}
