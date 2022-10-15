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
        $ids = data_get($data, 'data.relationships.regions.data.*.id');

        if ($ids) {
            $id = data_get($data, 'id');
            $this->federalDistrictRelationRepository->updateRelations($ids, $id);
        }

        return $next($data);
    }

}
