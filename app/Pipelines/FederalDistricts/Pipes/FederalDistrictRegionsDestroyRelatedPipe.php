<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

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

    public function handle(int $id, \Closure $next)
    {
        $this->federalDistrictRelationsRepository->destroyRelatedModels($id);

        return $next($id);
    }
}
