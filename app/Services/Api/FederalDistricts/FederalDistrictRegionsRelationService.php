<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;

final class FederalDistrictRegionsRelationService
{
    protected FederalDistrictRelationsRepository $federalDistrictRelationsRepository;

    /**
     * @param FederalDistrictRelationsRepository $federalDistrictRelationsRepository
     */
    public function __construct(FederalDistrictRelationsRepository $federalDistrictRelationsRepository)
    {
        $this->federalDistrictRelationsRepository = $federalDistrictRelationsRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(int $id): mixed
    {
        return $this->federalDistrictRelationsRepository->indexRelations('regions', $id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function saveRelations(array $data, int $id): void
    {
        $ids = data_get($data, 'data.*.id');

        $model = FederalDistrict::findOrFail($id);

        $this->federalDistrictRelationsRepository->saveRelations($ids, Region::class, $model);
    }
}
