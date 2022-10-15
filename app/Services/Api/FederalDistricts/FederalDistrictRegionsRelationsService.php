<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\FederalDistricts\FederalDistrictRegionsRelationsRepository;

final class FederalDistrictRegionsRelationsService
{
    protected FederalDistrictRegionsRelationsRepository $federalDistrictRelationsRepository;

    /**
     * @param FederalDistrictRegionsRelationsRepository $federalDistrictRelationsRepository
     */
    public function __construct(FederalDistrictRegionsRelationsRepository $federalDistrictRelationsRepository)
    {
        $this->federalDistrictRelationsRepository = $federalDistrictRelationsRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(int $id): mixed
    {
        return $this->federalDistrictRelationsRepository->indexRelations($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateRelations(array $data, int $id): void
    {
        $ids = data_get($data, 'data.*.id');

        $this->federalDistrictRelationsRepository->updateRelations($ids, $id);
    }
}
