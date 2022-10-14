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
            $model = data_get($data, 'model');
            $this->federalDistrictRelationRepository->updateRelations($ids, Region::class, $model);
        }

        return $next($data);
    }

}
