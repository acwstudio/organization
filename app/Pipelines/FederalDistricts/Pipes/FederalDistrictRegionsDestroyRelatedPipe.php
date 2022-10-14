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
        $model = data_get($data, 'model');

        $this->federalDistrictRegionsRelationsRepository->destroyRelatedModels('regions', $model);

        return $next($model);
    }
}
