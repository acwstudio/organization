<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Models\FederalDistrict;
use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;

final class FederalDistrictRegionsDestroyRelatedPipe
{
    protected FederalDistrictRelationsRepository $federalDistrictRelationsRepository;

    /**
     * @param FederalDistrictRelationsRepository $federalDistrictRelationsRepository
     */
    public function __construct(FederalDistrictRelationsRepository $federalDistrictRelationsRepository)
    {
        $this->federalDistrictRelationsRepository = $federalDistrictRelationsRepository;
    }

    /**
     * @param FederalDistrict $model
     * @param \Closure $next
     * @return mixed
     */
    public function handle(FederalDistrict $model, \Closure $next): mixed
    {
        $this->federalDistrictRelationsRepository->destroyRelatedModels('regions', $model);

        return $next($model);
    }
}
