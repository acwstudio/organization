<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;

final class FederalDistrictRegionsStoreRelationshipsPipe
{
    protected FederalDistrictRelationsRepository $federalDistrictRelationRepository;

    /**
     * @param FederalDistrictRelationsRepository $federalDistrictRelationRepository
     */
    public function __construct(FederalDistrictRelationsRepository $federalDistrictRelationRepository)
    {
        $this->federalDistrictRelationRepository = $federalDistrictRelationRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     * @throws \ReflectionException
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $relationData = data_get($data, 'data.relationships.regions');

        if ($relationData) {
            data_set($data, 'relation_data', $relationData);
            data_set($data, 'relation_method', 'regions');

            $this->federalDistrictRelationRepository->updateRelations($data);
        }

        return $next($data);
    }
}
