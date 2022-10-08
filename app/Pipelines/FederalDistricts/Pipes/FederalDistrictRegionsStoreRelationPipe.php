<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;

final class FederalDistrictRegionsStoreRelationPipe
{
    protected FederalDistrictRelationsRepository $federalDistrictRegionsRelationRepository;

    /**
     * @param FederalDistrictRelationsRepository $federalDistrictRegionsRelationRepository
     */
    public function __construct(FederalDistrictRelationsRepository $federalDistrictRegionsRelationRepository)
    {
        $this->federalDistrictRegionsRelationRepository = $federalDistrictRegionsRelationRepository;
    }

    public function handle(array $data, \Closure $next): mixed
    {
        // Probably something to do in the future

        return $next($data);
    }
}
