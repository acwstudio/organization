<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Models\Region;
use App\Repositories\Api\FederalDistricts\FederalDistrictRegionsRelationsRepository;

final class FederalDistrictRegionsUpdateRelationPipe
{
    protected FederalDistrictRegionsRelationsRepository $federalDistrictRelationRepository;

    /**
     * @param FederalDistrictRegionsRelationsRepository $federalDistrictRelationRepository
     */
    public function __construct(FederalDistrictRegionsRelationsRepository $federalDistrictRelationRepository)
    {
        $this->federalDistrictRelationRepository = $federalDistrictRelationRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $relationshipsData = data_get($data, 'data.relationships.regions');

        if ($relationshipsData) {
            data_set($relationshipsData, 'federal_district_id', data_get($data, 'federal_district_id'));
            $this->federalDistrictRelationRepository->updateRelations($relationshipsData);
        }

        return $next($data);
    }

}
