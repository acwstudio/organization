<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRegionsRelationsRepository;

final class FederalDistrictRegionsUpdateRelationshipsPipe
{
    protected FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationRepository;

    /**
     * @param FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationRepository
     */
    public function __construct(FederalDistrictRegionsRelationsRepository $federalDistrictRegionsRelationRepository)
    {
        $this->federalDistrictRegionsRelationRepository = $federalDistrictRegionsRelationRepository;
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

            $this->federalDistrictRegionsRelationRepository->updateToManyRelationships($relationshipsData);
        }

        return $next($data);
    }

}