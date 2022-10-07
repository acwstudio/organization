<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Models\Region;
use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;

final class FederalDistrictRegionsUpdateRelationPipe
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
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $ids = data_get($data, 'data.relationships.regions.data.*.id');

        if ($ids) {
            $model = data_get($data, 'model');
            $this->federalDistrictRelationRepository->saveRelations($ids, Region::class, $model);
        }

        return $next($data);
    }

}
