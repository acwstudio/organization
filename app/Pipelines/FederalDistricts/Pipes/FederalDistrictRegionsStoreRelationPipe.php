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
        $relationshipsData = data_get($data, 'data.relationships.regions');

        if ($relationshipsData) {
            data_set($relationshipsData, 'region_id', data_get($data, 'model')->id);

//        $this->regionCitiesRelationsRepository->anyFineMethod($relationshipsData);
        }

        return $next($data);
    }
}
