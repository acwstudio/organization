<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRelationshipsRepository;

final class FederalDistrictRegionsUpdateRelationshipsPipe
{
    protected FederalDistrictRelationshipsRepository $federalDistrictRelationRepository;

    /**
     * @param FederalDistrictRelationshipsRepository $federalDistrictRelationRepository
     */
    public function __construct(FederalDistrictRelationshipsRepository $federalDistrictRelationRepository)
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
        $relationData = data_get($data, 'data.relationships.regions');

        if ($relationData) {
            data_set($data, 'relation_data', $relationData);
            data_set($data, 'relation_method', 'regions');

            $this->federalDistrictRelationRepository->updateRelations($data);
        }

        return $next($data);
    }

}
