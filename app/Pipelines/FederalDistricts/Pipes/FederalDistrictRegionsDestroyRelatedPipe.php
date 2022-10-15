<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Models\FederalDistrict;
use App\Repositories\Api\FederalDistricts\FederalDistrictRegionsRelationsRepository;

final class FederalDistrictRegionsDestroyRelatedPipe
{
    protected FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationsRepository;

    /**
     * @param FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationsRepository
     */
    public function __construct(FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationsRepository)
    {
        $this->federalDistrictRegionsRelationsRepository = $federalDistrictRegionsRelationsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $id = data_get($data, 'id');

        $this->federalDistrictRegionsRelationsRepository->destroyRelations($id);

        return $next($data);
    }
}
