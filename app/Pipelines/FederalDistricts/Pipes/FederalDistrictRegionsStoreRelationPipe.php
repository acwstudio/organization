<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRegionsRelationsRepository;

final class FederalDistrictRegionsStoreRelationPipe
{
    protected FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationRepository;

    /**
     * @param FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationRepository
     */
    public function __construct(FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationRepository)
    {
        $this->federalDistrictRegionsRelationRepository = $federalDistrictRegionsRelationRepository;
    }

    public function handle(array $data, \Closure $next): mixed
    {
        // Probably something to do in the future

        return $next($data);
    }
}
